<?php

namespace App\Service;

use App\Entity\Tide;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;

class Scraper {

    public function scrapPorts() {
        $url = 'http://maree.info/8';

        $client = new Client();

        $response = $client->get($url)->getBody()->getContents();

        $crawler = new Crawler($response);

        $lowHour = $crawler->filter('td.SEPV > span')->getNode(0)->textContent;
        $coef = (float) $crawler->filter('td.Coef > b')->getNode(0)->textContent;

        $tide = new Tide();
        $tide->setLowHour($lowHour);
        $tide->setCoefficient($coef);

        dd($tide);
    }
}