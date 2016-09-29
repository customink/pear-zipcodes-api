<?php namespace App\Processors\ElasticSearch\OutputProcessor;

use App\Processors\ElasticSearch\DocumentFormatter\InfoDocumentFormatter;

class InfoOutputProcessor extends AbstractOutputProcessor
{
    public function withGeoJson() {

    }

    public function getArray($options = [])
    {
        return array_map(function ($document) {
            return with(new InfoDocumentFormatter($document))->format();
        }, $this->documents);
    }
}