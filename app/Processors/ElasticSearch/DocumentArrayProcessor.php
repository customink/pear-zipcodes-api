<?php namespace App\Processors\ElasticSearch;

use App\Processors\ElasticSearch\DocumentFormatter\GeoJsonDocumentFormatter;
use App\Processors\ElasticSearch\DocumentFormatter\GeoJsonFullDocumentFormatter;
use App\Processors\ElasticSearch\DocumentFormatter\InfoDocumentFormatter;
use App\Processors\ElasticSearch\OutputProcessor\GeoJsonOutputProcessor;
use App\Processors\ElasticSearch\OutputProcessor\InfoOutputProcessor;
use App\Processors\ElasticSearch\OutputProcessor\JsendSearchResult;
use App\Processors\ElasticSearch\OutputProcessor\JsendDataResult;
use App\Processors\ElasticSearch\OutputProcessor\ResultsOutputProcessor;


class DocumentArrayProcessor
{
    /**
     * @var array
     */
    protected $unprocessed;
    protected $includeImbeddedGeojson;

    public function __construct($unprocessed, $methodType)
    {
        $this->unprocessed = $unprocessed;
        $this->methodType = $methodType;
    }

    public function geojson()
    {
        return new GeoJsonOutputProcessor($this->unprocessed);
    }

    public function info()
    {
        return new InfoOutputProcessor($this->unprocessed);
    }

    public function results($options = [])
    {
        return new ResultsOutputProcessor($this->unprocessed, $options);
    }

    public function getJsendArray($options = []) {
        if ($this->methodType === 'search') {
            return [
                'status' => 'success',
                'data' => with(new JsendSearchResult($this->unprocessed))->get($options)
            ];
        }
        return [
            'status' => 'success',
            'data' => with(new JsendDataResult($this->unprocessed))->get()
        ];
    }

//    public function getGeoJsonArray($options = []) {
//        if ($this->methodType === 'get') {
//            return [
//                'type' => 'FeatureCollection',
//                'crs' => [
//                    'type' => 'name',
//                    'properties' => [
//                        'name' => 'urn:ogc:def:crs:OGC:1.3:CRS84'
//                    ]
//                ],
//                'features' => array_map(function ($document) {
//                    return with(new GeoJsonFullDocumentFormatter($document))->format();
//                }, $this->unprocessed)
//            ];
//        }
//
//        return [
//            'type' => 'FeatureCollection',
//            'crs' => [
//                'type' => 'name',
//                'properties' => [
//                    'name' => 'urn:ogc:def:crs:OGC:1.3:CRS84'
//                ]
//            ],
//            'features' => array_map(function ($document) {
//                return with(new GeoJsonDocumentFormatter($document))->format();
//            }, $this->unprocessed)
//        ];
//    }
}