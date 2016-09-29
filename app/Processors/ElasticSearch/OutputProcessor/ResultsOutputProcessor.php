<?php namespace App\Processors\ElasticSearch\OutputProcessor;

use App\Processors\ElasticSearch\DocumentFormatter\GeoJsonFullDocumentFormatter;
use App\Processors\ElasticSearch\DocumentFormatter\InfoDocumentFormatter;

class ResultsOutputProcessor extends AbstractOutputProcessor
{
    protected $wants;
    protected $includeGeoJson;

    function __construct($documents, array $options = [])
    {
        parent::__construct($documents, $options);
        $this->wants = isset($options['wants']) ? $options['wants'] : 'ZipCode';
    }

    public function withGeoJson()
    {
        $this->includeGeoJson = true;
        return $this;
    }

    public function getArray($options = [])
    {
        $wants = $this->wants;



        if (isset($this->options['resultsTransformer']) and is_callable($this->options['resultsTransformer'])) {
            $transformFunction = $this->options['resultsTransformer'];
        } else {
            $transformFunction = function ($document) use ($wants) {
                return $document['_source']['properties'][$wants];
            };
        }

        $output = [
            'results' => array_map( $transformFunction , $this->documents),
        ];

        if ($this->includeGeoJson) {
            $output['geojson'] = with(new GeoJsonOutputProcessor($this->documents))->getArray();
        }

        return $output;
    }
}