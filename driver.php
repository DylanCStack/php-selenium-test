<?php

require_once('vendor/autoload.php');
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

$baseUrl = 'localhost:8000';

// See if the selenium executable exists, if not download it because what's the point of automation if you have to do it yourself.
if(!glob('selenium.jar')) {
  file_put_contents(__DIR__.'/selenium.jar', file_get_contents('https://goo.gl/tbd1NS'));
}

// start the selenium server in the background
exec('java -jar selenium.jar > /dev/null &');
sleep(2); // wait for the server to start

// start a simple web server in the background
exec('php -S '.$baseUrl.' > /dev/null &');

$host = 'http://localhost:4444/wd/hub';
$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome(), 5000);

$driver->get($baseUrl);

$driver->findElement(WebDriverBy::name('firstName'))->sendKeys('First of the names');
$driver->findElement(WebDriverBy::name('lastName'))->sendKeys('Name that comes last');
$driver->findElement(WebDriverBy::name('zipCode'))->sendKeys('1423');
$driver->findElement(WebDriverBy::id('importantForm'))->submit();

$driver->wait()->until(function () use (&$driver) {
  echo ($driver->getCurrentURL());
  return true;
});


$driver->quit();
exec('lsof -t -i :4444 | xargs kill > /dev/null &');
exec('killall php > /dev/null &');

