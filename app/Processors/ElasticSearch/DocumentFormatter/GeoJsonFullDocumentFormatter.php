<?php namespace App\Processors\ElasticSearch\DocumentFormatter;

class GeoJsonFullDocumentFormatter extends AbstractDocumentFormatter
{
    public function format($options = [])
    {
        if ( ! isset($this->document['_source'])) {
            return [
                'type' => 'Feature',
                'properties' => [
                    'zipcode' => $this->document['_id'],
                    'not_found' => true,
                ],
                'geometry' => null,
            ];
        }

        $source = $this->document['_source'];

        return $source;
    }
}