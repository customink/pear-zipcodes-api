<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

Route::get('/test', function (Request $request) {
    $params = [
        'index' => config('elasticsearch.index'),
        'type' => 'zipcodes',
        'id' => '43451',
        'client' => [
            'verbose' => false
        ]
    ];
    $response = \ES::get($params);
    return response()->json($response);
});

Route::get('/zips/boundaries', function (Request $request) {
    $zips = explode(',', $request->query('q'));
    $wantsFile = $request->query('file');
    $params = [
        'index' => config('elasticsearch.index'),
        'type' => 'zipcodes',
        'body' => [
            'docs' => array_map(function ($zip) {
            return [
                '_id' => $zip,
            ];
        }, $zips)]
    ];

    $response = \ES::mget($params);

    $output = with(new App\Processors\ESearchResponseToGeojsonProcessor($response))->process();

    if ($wantsFile) {
        $filePath = storage_path('app/data/' . uniqid() . '.geojson');
        \File::put($filePath, json_encode($output));
        return response()->download($filePath)->deleteFileAfterSend(true);
    } else {
        return response()->json($output); //->setEncodingOptions(15 | JSON_PRETTY_PRINT]);
    }

});

Route::get('zips/reverse_geocode', function (Request $request) {
    $lat = $request->query('lat');
    $long = $request->query('long');

    $params = [
        'index' => config('elasticsearch.index'),
        'type' => 'zipcodes',
        'body' => [
            'query' => [
                'bool' => [
                    'must' => ['match_all' => []],
                    'filter' => [
                        'geo_shape' => [
                            'geometry' => [
                                'shape' => [
                                    'type' => 'point',
                                    'coordinates' => [$long, $lat]
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    $results = \ES::search($params);
    $output = [
        'status' => 'success',
        'data' => ['found' => false]
    ];

    if ($results['hits']['total']) {
        $data = $results['hits']['hits'][0];
        $payload = [
            'found' => true,
            'zipcode' => $data['_id'],
            'geojson' => $data['_source'],
        ];
        $output = [
            'status' => 'success',
            'data' => $payload
        ];
    }

    return response()->json($output);

});

Route::get('zips/boundaries/random_zips', function (Request $request) {
    $params = [
        'index' => config('elasticsearch.index'),
        'type' => 'zipcodes',
        '_source_include' => 'properties.GEOID10',
        'body' => [
            'query' => [
                'match_all' => []
            ]
        ]
    ];

    $response = ES::search($params);

    $output = array_map(function ($result) {
        return $result['_source']['properties']['GEOID10'];
    }, $response['hits']['hits']);


    dd('pear-zip.dev/api/zips/boundaries/?q=' . implode(',', $output));
});

Route::get('zips/{zipcode}', function ( $zipcode ) {

    $params = [
       'index' => config('elasticsearch.index'),
       'type' => 'zipcodes',
        'id' => $zipcode,
   ];

    $response = ES::get($params);

    return response()->json($response['_source']);
});