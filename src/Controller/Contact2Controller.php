<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactRepository;

/**
 * @Route("/contact2")
 */
class Contact2Controller extends AbstractController
{
    /**
     * @Route("/", name="contact2_index")
     */
    public function index(ContactRepository $contactRepository)
    {
        $contacts = $contactRepository->findAll();
        dump($contacts);
        exit;
        return $this->render('contact2/index.html.twig', []);
    }
}
