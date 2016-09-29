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

Route::get('test', function (Request $request) {
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

// Query q
// Query file
// Query geojson
Route::get('zips/boundaries', function (Request $request) {
    $zips = explode(',', $request->query('q'));
    $wantsFile = $request->query('file');
    $wantsGeoJson = $request->query('geojson');
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

    $output = Result::mget($response)->geojson()->compact()->getArray();

    if ($wantsFile === 'true') {
        $filePath = storage_path('app/data/' . uniqid() . '.geojson');
        \File::put($filePath, json_encode($output));
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    if ($wantsGeoJson === 'true') {
        return response()->json($output);
    }

    return response()->jsend('success', $output); //->setEncodingOptions(15 | JSON_PRETTY_PRINT]);


});

// Query q
// Query file
Route::get('zips/info', function ( Request $request ) {
    $zips = explode(',', $request->query('q'));
    $wantsFile = $request->query('file');
    $params = [
        'index' => config('elasticsearch.index'),
        'type' => 'zipcodes',
        'body' => [
            'docs' => array_map(function ($zip) {
                return [
                    '_id' => $zip,
                    '_source' => [
                        'exclude' => ['geometry']
                    ],
                ];

            }, $zips),
        ]
    ];

    $response = \ES::mget($params);

    $output = Result::mget($response)->info()->getArray();

    if ($wantsFile) {
        $filePath = storage_path('app/data/' . uniqid() . '.geojson');
        \File::put($filePath, json_encode($output));
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    return response()->jsend('success', $output); //->setEncodingOptions(15 | JSON_PRETTY_PRINT]);

});

// Query lat
// Query long
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

    $output = Result::search($results)
        ->results(['wants' => 'CityMixedCase', 'resultsTransformer' => function ($document) {
            $properties = $document['_source']['properties'];
            return $properties['CityMixedCase'] . ', ' . $properties['State'];
        }])
        ->withGeoJson()
        ->getArray();

    return response()->jsend('success', $output);

});

Route::get('zips/boundaries/random_zips', function (Request $request) {
    $params = [
        'index' => config('elasticsearch.index'),
        'type' => 'zipcodes',
        '_source_include' => 'properties.GEOID10',
        'body' => [
            'query' => [
                'match_all' => [],
            ],
        ]
    ];

    $response = ES::search($params);

    $output = array_map(function ($result) {
        return $result['_source']['properties']['GEOID10'];
    }, $response['hits']['hits']);

    return 'pear-zip.dev/api/zips/boundaries/?q=' . implode(',', $output);
});

Route::get('zips/{zipcode}', function ( $zipcode ) {

    $params = [
       'index' => config('elasticsearch.index'),
       'type' => 'zipcodes',
        'id' => $zipcode,
   ];

    try {
        $response = ES::get($params);
    } catch (\Exception $e) {
        $response = ['_id' => $zipcode];
    }

    $output = Result::get($response)->geojson()->getArray();
    return response()->jsend('success', $output);
});

Route::get('zips/{zipcode}/info', function ( $zipcode ) {
    $params = [
        'index' => config('elasticsearch.index'),
        'type' => 'zipcodes',
        'id' => $zipcode,
        '_source_exclude' => [
            'geometry'
        ]
    ];

    try {
        $response = ES::get($params);
    } catch (\Exception $e) {
        $response = ['_id' => $zipcode];
    }

    $output = Result::get($response)->info()->getArray();
    return response()->jsend('success', $output);
});

// Query: q
// Query: add_geojson
Route::get('cities/search', function (Request $request) {
    $query = $request->query('q');
    $withGeoJson = $request->query('add_geojson') === 'true';

    $params = [
        'index' => config('elasticsearch.index'),
        'type' => 'zipcodes',
        'body' => [
            'sort' => [
               ['properties.Population' => 'desc']
            ],


            'query' => [
                'bool' => [
                    'must' => ['match' => [
                        "properties.CityMixedCase" => $query
                    ]],
                    'filter' => [
                        ['limit' => ['value' => 1]]
                    ],
                ],

            ]
        ]
    ];

    $results = \ES::search($params);

    $transformer = function ($document) {
        $properties = $document['_source']['properties'];
        return $properties['CityMixedCase'] . ', ' . $properties['State'];
    };
    /**
     * @var $builder \App\Processors\ElasticSearch\OutputProcessor\ResultsOutputProcessor
     */
    $builder = Result::search($results)->results(['resultsTransformer' => $transformer]);

    if ($withGeoJson) {
        $builder->withGeoJson();
    }

    $output = $builder->getArray();

    return response()->jsend('success', $output);
});

Route::get('msa/search', function(Request $request) {

});