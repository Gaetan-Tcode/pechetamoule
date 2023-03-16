<?php

namespace App\Controller;

use App\Entity\Harbor;
use App\Service\Scraper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('', name: 'app_test')]
    public function index(Scraper $scraper, EntityManagerInterface $manager): Response
    {
        $scraper->harbors();

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'harbors' => $manager->getRepository(Harbor::class)->findAll(),
        ]);
    }
}
