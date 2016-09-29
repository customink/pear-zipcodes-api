<?php namespace App\Processors\ElasticSearch\DocumentFormatter;

class InfoDocumentFormatter extends AbstractDocumentFormatter
{
    public function format($options = [])
    {
        if (! isset($this->document['_source'])) {
            return null;
        }
        $source = $this->document['_source'];
        return $source['properties'];
    }
}