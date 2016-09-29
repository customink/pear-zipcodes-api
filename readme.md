## Zipcodes API

### Features
1. Manages Elasticsearch Index Mapping for zipcode boundaries and demographic information
2. GeoJSON for zipcode boundaries
3. Multiple zipcodes in one query
4. Reverse Geolocates zipcode given latitude and longitude

### Routes
1. `https://zipcodes-api.pearup.com/api/zips/boundaries?q=60613,60602...`  if `file=true` is given, the result will be downloaded to as a file.
2. `https://zipcodes-api.pearup.com/api/zips/search?lat=41.91990&long=-87.67491`

## TODO
* Zipcodes by city and state
