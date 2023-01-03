<?php

require('vendor/autoload.php');

use Codespace\PhpChallenges\Scraper;
use Codespace\PhpChallenges\GitHubClient;
use Codespace\PhpChallenges\Weather;
use Codespace\PhpChallenges\YouTubeScraper;

var_dump((new GitHubClient('moisesgaspar22'))->printRepoSize());

var_dump((new Scraper())->getProductDescriptions('https://www.testsieger.de'));

var_dump((new YouTubeScraper('AIzaSyBDrfzbF0jl1YPXIbhltuTWM7vVbl_YfAI'))->getVideoStatisticsFromVideo('dQw4w9WgXcQ'));

// Call strait up
var_dump((new Weather('ff081c92f93464e06301f7576544d543'))->getCurrentWeatherFromLocation('Lisbon'));

// Call as callback
var_dump(call_user_func_array(
    [new Weather('ff081c92f93464e06301f7576544d543'), 'getCurrentWeatherFromLocation'], 
    ['lisbon']
));