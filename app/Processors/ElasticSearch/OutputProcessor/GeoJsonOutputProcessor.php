<?php namespace App\Processors\ElasticSearch\OutputProcessor;

use App\Processors\ElasticSearch\DocumentFormatter\GeoJsonDocumentFormatter;
use App\Processors\ElasticSearch\DocumentFormatter\GeoJsonFullDocumentFormatter;
use App\Processors\ElasticSearch\DocumentFormatter\InfoDocumentFormatter;
use Elasticsearch\Endpoints\Nodes\Info;

class GeoJsonOutputProcessor extends AbstractOutputProcessor
{
    protected $compact = false;
    protected $wrapCollection = true;

//    public function get($options = [])
//    {
//        return array_map(function ($document) {
//            return with(new InfoDocumentFormatter($document))->format();
//        }, $this->documents);
//    }

    public function compact()
    {
        $this->compact = true;
        return $this;
    }

    public function single()
    {
        $this->wrapCollection = false;
        return $this;
    }

    protected function wrapGeoJsonCollection($featuresArray)
    {
        return [
            'type' => 'FeatureCollection',
            'features' => $featuresArray
        ];
    }

    protected function getSingleArray()
    {
        if ($this->compact) {
            return array_map(function ($document) {
                return with(new GeoJsonDocumentFormatter($document))->format();
            }, $this->documents);
        }

        return array_map(function ($document) {
            return with(new GeoJsonFullDocumentFormatter($document))->format();
        }, $this->documents);
    }

    protected function getWrappedArray()
    {
        if ($this->compact) {
            return $this->wrapGeoJsonCollection(
                array_map(function ($document) {
                    return with(new GeoJsonDocumentFormatter($document))->format();
                }, $this->documents)
            );
        }

        return $this->wrapGeoJsonCollection(
            array_map(function ($document) {
                return with(new GeoJsonFullDocumentFormatter($document))->format();
            }, $this->documents)
        );
    }

    protected function autoDetectWrapCollection() {
        count($this->documents) === 1 ? $this->single() : null;
    }

    public function getArray()
    {
        $this->autoDetectWrapCollection();
        if ($this->wrapCollection) {
            return $this->getWrappedArray();
        }
        return $this->getSingleArray();
    }

}