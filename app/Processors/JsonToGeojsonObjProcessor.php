<?php namespace App\Processors;

use GeoJson\GeoJson;

class JsonToGeojsonObjProcessor
{
    protected $unprocessed;

    function __construct($json) {
        $this->unprocessed = json_decode($json);
    }

    public function process() {
        return \GeoJson\GeoJson::jsonUnserialize($this->unprocessed);
    }
}