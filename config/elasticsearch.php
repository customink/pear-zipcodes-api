<?php

return [
    'hosts' => explode(',', env('ELASTIC_HOST', 'localhost:9200')),
    'index' => env('ELASTIC_INDEX', 'zipcode_live'),
    'boundary_file' => storage_path('app/data/' . env('ELASTIC_BOUNDARY_GEOJSON')),
    'zipcode_file' => storage_path('app/data/' . env('ELASTIC_ZIPCODE_FILE')),
];