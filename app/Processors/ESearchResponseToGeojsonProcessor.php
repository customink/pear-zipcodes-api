<?php namespace App\Processors;

class ESearchResponseToGeojsonProcessor
{
    protected $unprocessed;

    function __construct($responseArray)
    {
        $this->unprocessed = $responseArray;
    }

    public function process()
    {
        return [
            'type' => 'FeatureCollection',
            'crs' => [
                'type' => 'name',
                'properties' => [
                    'name' => 'urn:ogc:def:crs:OGC:1.3:CRS84'
                ]
            ],
            'features' => (array) $this->mapResult($this->unprocessed['docs'])
        ];
    }

    protected function mapResult($array) {
        return array_map(function ($result) {
            if ($result['found']) {
                return $result['_source'];
            }
            return [
                'type' => 'Feature',
                'properties' => [],
                'geometry' => [
                    'type' => 'Polygon',
                    'coordinates' => [],
                ]
            ];
        }, $array);
    }

    protected function filterResult($array) {
        return array_filter($array);
    }
}