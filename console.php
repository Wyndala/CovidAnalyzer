<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 25.04.2018
 * Time: 15:09
 */

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new \Wyndala\CovidAnalyzer\Command\JohnsHopkinsImportCommand());

$application->run();