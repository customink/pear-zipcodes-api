<?php namespace App\Processors\ElasticSearch\DocumentFormatter;

class GeoJsonDocumentFormatter extends AbstractDocumentFormatter
{
    protected function formatPoint() {
        $properties = $this->document['_source']['properties'];
        return [
            'type' => 'Point',
            'properties' => [
                'ZipCode' => $properties['ZipCode'],
                'CityMixedCase' => $properties['CityMixedCase'],
                'State' => $properties['State'],
            ],
            'coordinates' => [(float) $properties['Longitude'], (float) $properties['Latitude']]
        ];
    }

    protected function missingGeometry() {
        return ! isset($this->document['_source']['type']);
    }

    public function format($options = [])
    {
        if ( ! isset($this->document['_source'])) {
            return [
                'type' => 'Feature',
                'properties' => [
                    'ZipCode' => $this->document['_id'],
                    'not_found' => true,
                ],
                'geometry' => null,
            ];
        }

        $source = $this->document['_source'];

        if ($this->missingGeometry()) {
            return $this->formatPoint();
        }

        return [
            'type' => $source['type'],
            'properties' => [
                'ZipCode' => $source['properties']['GEOID10'],
                'CityMixedCase'    => isset($source['properties']['CityMixedCase']) ? $source['properties']['CityMixedCase'] : null,
                'State'   => isset($source['properties']['State']) ? $source['properties']['State'] : null,
            ],
            'geometry' => $source['geometry'],
        ];
    }
}