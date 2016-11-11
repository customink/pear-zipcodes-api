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
