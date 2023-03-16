<?php

namespace App\Controller;

use App\Service\Scraper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('', name: 'app_test')]
    public function index(Scraper $scraper): Response
    {
        $scraper->harbors();
        $scraper->tides('LE_TOUQUET');
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
