<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/page-accueil", name="home")
     */
    public function index()
    {
      $names = [
        'roger',
        '',
        'andrew',
        '',
        'david',
        'laurent'
      ];

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'names' => $names
        ]);
    }
}
