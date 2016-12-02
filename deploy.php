<?php namespace Deployer;

require 'recipe/laravel.php';
require 'vendor/deployer/recipes/cachetool.php';

set('ssh_type', 'ext-ssh2');
set('default_stage', 'staging');

set('cachetool', '127.0.0.1:9000');

// Set configurations
set('repository', 'git@github.com:ApparelMedia/pear-zipcodes-api.git');
set('writable_dirs', ['storage']);
set('writable_use_sudo', false);
set('shared_files', ['.env']);
set('shared_dirs', [
    'storage/app',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

task('copy:dotenv', function () {
    $sourceDotEnv = get('deploy_path') . '/shared/.env.' . get('stage_name');
    $targetDotEnv = get('deploy_path') .'/shared/.env';
    run("cp $sourceDotEnv $targetDotEnv");
})->desc('Copying .env file from file published by CI WebOps');

after('deploy:symlink', 'copy:dotenv');
after('deploy:symlink', 'cachetool:clear:opcache');

/**
 * Main task (Overwritting Default Laravel Task
 */
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'deploy:symlink',
    'cleanup',
    'artisan:cache:clear',
    'success',
])->desc('Deploy your project');

// Production Server
server('prod1', 'prod1.zipcodes')
    ->configFile('~/.ssh/config')
    ->set('deploy_path', '/opt/pear-zipcodes-api')
    ->set('stage_name', 'production')
    ->stage('production');

server('prod2', 'prod2.zipcodes')
    ->configFile('~/.ssh/config')
    ->set('deploy_path', '/opt/pear-zipcodes-api')
    ->set('stage_name', 'production')
    ->stage('production');

// Staging Server
server('stage1', 'stage1.zipcodes')
    ->configFile('~/.ssh/config')
    ->set('deploy_path', '/opt/pear-zipcodes-api')
    ->set('stage_name', 'staging')
    ->stage('staging');
