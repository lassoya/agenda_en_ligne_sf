<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use App\Entity\Phone;
use Doctrine\ORM\EntityManagerInterface;

class PhoneController extends AbstractController
{
    /**
     * @Route("/phone", name="phone")
     */
    public function index()
    {
        return $this->render('phone/index.html.twig', [
            'controller_name' => 'PhoneController',
        ]);
    }

    /**
     * @Route("/phone/{idContact}/{phone}", name="phone_edit")
     * @Route("/phone/{idContact}", name="phone_add")
     */
    public function edit(EntityManagerInterface $em, Request $request, Contact $idContact, Phone $phone = null) {
      if(!$phone) {
        $phone = new Phone();
        $em->persist($phone);
      }

      if('POST'=== $request->getMethod() &&
        $request->request->has('number')) {
          $number = $request->request->get('number');
          $phone->setNumber($number);
          $phone->setContact($idContact);

          $em->flush();

          return $this->redirectToRoute('contact2_edit', [
            'id' => $idContact->getId()
          ]);
      }

      return $this->render('phone/edit.html.twig', [
        'phone' => $phone
      ]);
    }

    /**
     * @Route("/phone/remove/{contact}/{phone}", name="phone_remove")
     */
    public function remove(EntityManagerInterface $em, Contact $contact, Phone $phone) {
        $em->remove($phone);
        $em->flush();

        return $this->redirectToRoute('contact2_edit', [
          'id' => $contact->getId()
        ]);
    }
}
