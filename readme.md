## Zipcodes API

### Features
1. Manages Elasticsearch Index Mapping for zipcode boundaries and demographic information
2. GeoJSON for zipcode boundaries
3. Multiple zipcodes in one query
4. Reverse Geolocates zipcode given latitude and longitude

### Routes
1. `https://zipcodes-api.pearup.com/api/zips/boundaries?q=60613,60602...`  if `file=true` is given, the result will be downloaded to as a file.
2. `https://zipcodes-api.pearup.com/api/zips/search?lat=41.91990&long=-87.67491`

### Updating the Database
#### Getting the `zipcodes.geojson`
1. Download the latest zcta zip file from [US Census website](https://www.census.gov/geo/maps-data/data/cbf/cbf_zcta.html)
2. Extract the zip to your computer
3. install `gdal` by running `brew install gdal` (assuming you have homebrew installed)
4. Navigate to the extracted directory in your terminal and note the filename of the `shp` file
5. run `ogr2ogr -f GeoJSON zipcodes.geojson [filename].shp`
6. upload the `zipcodes.geojson` file to the server using `scp`
7. `scp zipcodes.geojson apache@stage1.zipcodes:/opt/pear-zipcodes-api/shared/storage/app/data/zipcodes.geojson`
8. go the `/opt/pear-zipcodes-api/current` on the server and run `php artisan import:boundaries`.
9. The data will be `upserted`. There should not be any downtime and the changes are versioned.

#### Getting the `demographic.csv`
1. Download the complete csv file from zip-codes.com
2. rename it `demographic.csv`
3. upload the file to `/opt/pear-zipcodes-api/shared/storage/app/data/demographic.csv` on the server
4. go to `/opt/pear-zipcodes-api/current` on the server and run `php artisan import:demographic`

### Generating the Docs
It's using [API Blueprint](https://apiblueprint.org/) and [`aglio`](https://github.com/danielgtaylor/aglio) tool to generate the api documentation.  
To change the API docs, go to `apidoc.md` at the root of the project.  
Then run `aglio -i apidoc.md -o resources/views/welcome.blade.php`

### Deployment
This app uses [Deployer](http://deployer.org/), a zero-downtime deployment tool written in PHP and **heavily** inspired by Ruby's Capistrano.  
You can check out `deploy.php` to see what is involved.

Install Deployer by running `composer global require deployer/deployer:~4.0@dev herzult/php-ssh`  
Now when you run `dep`, you should see a wealth of commands you can run to manage your deployments.  
You'll also need to set up your `~/.ssh/config` for the servers like so:
```
Host prod1.nonprofit
    HostName prod.host.example.com
    User someuser
    IdentityFile /home/vagrant/.ssh/id_rsa
```

To deploy, you can run `dep deploy` to deploy to staging, and `dep deploy production` to deploy to production

### TODO
* Need to make boundary by city/state search strictly on city (right now it includes "Chicago Heights" when searching "Chicago", for example)
