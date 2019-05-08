<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContactRepository;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;

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

        return $this->render('contact2/index.html.twig', [
          'contacts' => $contacts
        ]);
    }

    /**
    * @Route("/remove/{id}", name="contact2_remove", methods={"GET"})
    */
    public function remove(EntityManagerInterface $entityManager, Contact $contact) {
      $entityManager->remove($contact);
      $entityManager->flush();

      return $this->redirectToRoute('contact2_index');
    }

    /**
    * @Route("/edit/{id}", name="contact2_edit", methods={"GET", "POST"})
    */
    public function edit(Request $request, Contact $contact){
        dump($request->get('firstname'));
        dump($request->getMethod());
        exit;
      return $this->render('contact2/edit.html.twig', [
        'contact' => $contact,
        'genders' => Contact::GENDERS
      ]);
    }
}
