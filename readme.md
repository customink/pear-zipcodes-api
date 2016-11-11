## Zipcodes API

### Features
1. Manages Elasticsearch Index Mapping for zipcode boundaries and demographic information
2. GeoJSON for zipcode boundaries
3. Multiple zipcodes in one query
4. Reverse Geolocates zipcode given latitude and longitude

### Routes
1. `https://zipcodes-api.pearup.com/api/zips/boundaries?q=60613,60602...`  if `file=true` is given, the result will be downloaded to as a file.
2. `https://zipcodes-api.pearup.com/api/zips/search?lat=41.91990&long=-87.67491`

### Generating the Docs
It's using [API Blueprint](https://apiblueprint.org/) and [`aglio`](https://github.com/danielgtaylor/aglio) tool to generate the api documentation.  
To change the API docs, go to `apidoc.md` at the root of the project.  
Then run `aglio -i apidoc.md -o resources/views/welcome.blade.php

### TODO
* Need to make boundary by city/state search strictly on city (right now it includes "Chicago Heights" when searching "Chicago", for example)
