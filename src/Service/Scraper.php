<?php

namespace App\Service;

use App\Entity\Tide;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DomCrawler\Crawler;

class Scraper {

    private EntityManagerInterface $manager;
    private DateTimeFormatter $formatter;

    public function __construct(EntityManagerInterface $manager, DateTimeFormatter $formatter)
    {
        $this->manager = $manager;
        $this->formatter = $formatter;
    }

    public function harbors() {
        $url = 'http://www.horaire-maree.fr/';

        $client = new Client();

        $response = $client->get($url)->getBody()->getContents();

        $crawler = new Crawler($response);

        $groups = $crawler
            ->filter('.select_port')
            ->filter('optgroup')
            ->each(function (Crawler $optgroup, $i) {
                echo $optgroup->attr('label') . '<br />';

                $optgroup->children()->each(function (Crawler $option, $i) {
                    if ($option->nodeName() == 'option')
                        echo $option->text() . '<br />';
                });
            });

//                $groupNode
//                    ->filter('option')
//                    ->each(function ($optionNode, $i) {
//                        echo ' - ' . $optionNode->text() . '<br />';
//                    });
    }

    public function tides($harbor) {
        $date = '20230301';
        $url = 'http://www.horaire-maree.fr/maree/' . $harbor . '/';

        $client = new Client();

        $response = $client->get($url)->getBody()->getContents();

        $crawler = new Crawler($response);

        // morning & afternoon
        for ($i = 0; $i < 2; $i++) {
            // scrap
            $coef = $crawler
                ->filter($i % 2 == 0
                    ? 'tr.bluesoftoffice:nth-child(3) > td:nth-child(1) > strong:nth-child(1)'
                    : 'td.blueoffice:nth-child(4)')
                ->innerText();

            $lowHour = $crawler
                ->filter($i % 2 == 0
                    ? 'tr.bluesoftoffice:nth-child(3) > td:nth-child(2) > strong:nth-child(1)'
                    : 'tr.bluesoftoffice:nth-child(3) > td:nth-child(5) > strong:nth-child(1)')
                ->innerText();

            $highHour = $crawler
                ->filter($i % 2 == 0
                    ? 'tr.bluesoftoffice:nth-child(3) > td:nth-child(3) > strong:nth-child(1)'
                    : 'tr.bluesoftoffice:nth-child(3) > td:nth-child(6) > strong:nth-child(1)')
                ->innerText();

            $lowHeight = $crawler
                ->filter($i % 2 == 0
                    ? 'tr.bluesoftoffice:nth-child(3) > td:nth-child(2)'
                    : 'tr.bluesoftoffice:nth-child(3) > td:nth-child(5)')
                ->text();
            $lowHeight = (float) str_replace(',', '.', explode(' ', $lowHeight)[1]);

            $highHeight = $crawler
                ->filter($i % 2 == 0
                    ? 'tr.bluesoftoffice:nth-child(3) > td:nth-child(3)'
                    : 'tr.bluesoftoffice:nth-child(3) > td:nth-child(6)')
                ->text();
            $highHeight = (float) str_replace(',', '.', explode(' ', $highHeight)[1]);

            // new instance & persist
            $tide = new Tide();

            $tide->setLowHour($this
                ->formatter
                ->format($date, $lowHour)
            );
            $tide->setHighHour($this
                ->formatter
                ->format($date, $highHour)
            );

            $tide->setLowHeight($lowHeight);
            $tide->setHighHeight($highHeight);

            $tide->setCoefficient($coef);

            $this->manager->persist($tide);
        }

        $this->manager->flush();
    }
}