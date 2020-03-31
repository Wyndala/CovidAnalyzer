<?php

namespace Wyndala\CovidAnalyzer\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JohnsHopkinsImportCommand extends Command
{
    protected static $defaultName = 'covid:import:jhu';

    public function configure()
    {
        $this->setDescription('Imports data from johns hopkins university');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $timeSeriesUrl = 'https://corona.lmao.ninja/v2/historical/germany';
        $currentDayUrl = 'https://corona.lmao.ninja/countries/germany';

        $client = new Client(['verify' => false]);

        $timeSeriesJson = $client->get($timeSeriesUrl)->getBody()->getContents();
        $currentDayJson = $client->get($currentDayUrl)->getBody()->getContents();

        $timeSeriesArray = json_decode($timeSeriesJson, true);
        $currentDayArray = json_decode($currentDayJson, true);

        $timeSeriesArray['timeline']['cases'][date('m/d/y')] = $currentDayArray['cases'];
        $timeSeriesArray['timeline']['deaths'][date('m/d/y')] = $currentDayArray['deaths'];
        $timeSeriesArray['timeline']['recovered'][date('m/d/y')] = $currentDayArray['recovered'];


        file_put_contents('public/json/stats.json', json_encode($timeSeriesArray, JSON_UNESCAPED_SLASHES));

        return 0;
    }
}