<?php

namespace Darkish\CategoryBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateWeatherCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('darkish:weather:update')
            ->setDescription('Update weather information')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
        $yql_query = "select * from weather.forecast where woeid = 2236273 and u='c'";
        $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&u=c&format=json";
        // Make call with cURL
        $session = curl_init($yql_query_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
        $json = curl_exec($session);


        file_put_contents($this->getContainer()->get('kernel')->getRootDir().'/Resources/data/weather.json',
            $json
        );

        $output->writeln($json);
    }
}