<?php

namespace App\Service;

use App\Entity\Harbor;
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

                $optgroup->children()->each(function (Crawler $option, $i) use ($optgroup) {
                    if ($option->nodeName() != 'option') return;

                    $harbor = new Harbor();

                    $harbor->setname($option->text());
                    $harbor->setDepartment($optgroup->attr('label'));
                    $harbor->setLatitude('');
                    $harbor->setLongitude('');

                    $this->manager->persist($harbor);
                });

                $this->manager->flush();
            });
    }

    public function tides($harbor) {
        $url = 'http://www.horaire-maree.fr/';

        $client = new Client();

        $response = $client->get($url)->getBody()->getContents();

        $crawler = new Crawler($response);

        $crawler->filter('#footer_ports1 > ul > li')->filter('a')
            ->each(function (Crawler $a, $i) use ($harbor, $client) {
                $date = '20230301';

                $response = $client->get($a->link()->getUri())->getBody()->getContents();
                $tideCrawler = new Crawler($response);

                // morning & afternoon
                for ($i = 0; $i < 2; $i++) {
                    // scrap
                    $coef = $tideCrawler
                        ->filter($i % 2 == 0
                            ? 'tr.bluesoftoffice:nth-child(3) > td:nth-child(1) > strong:nth-child(1)'
                            : 'td.blueoffice:nth-child(4)')
                        ->innerText();

                    $lowHour = $tideCrawler
                        ->filter($i % 2 == 0
                            ? 'tr.bluesoftoffice:nth-child(3) > td:nth-child(2) > strong:nth-child(1)'
                            : 'tr.bluesoftoffice:nth-child(3) > td:nth-child(5) > strong:nth-child(1)')
                        ->innerText();

                    $highHour = $tideCrawler
                        ->filter($i % 2 == 0
                            ? 'tr.bluesoftoffice:nth-child(3) > td:nth-child(3) > strong:nth-child(1)'
                            : 'tr.bluesoftoffice:nth-child(3) > td:nth-child(6) > strong:nth-child(1)')
                        ->innerText();

                    $lowHeight = $tideCrawler
                        ->filter($i % 2 == 0
                            ? 'tr.bluesoftoffice:nth-child(3) > td:nth-child(2)'
                            : 'tr.bluesoftoffice:nth-child(3) > td:nth-child(5)')
                        ->text();
                    $lowHeight = (float) str_replace(',', '.', explode(' ', $lowHeight)[1]);

                    $highHeight = $tideCrawler
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

                    $tide->setHarbor($harbor);

                    $this->manager->persist($tide);
                }

                $this->manager->flush();
            });
    }
}