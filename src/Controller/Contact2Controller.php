<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Repository\ContactRepository;
use App\Entity\Contact;
use App\Entity\Phone;
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
    * @Route("/add", name="contact2_add", methods={"GET", "POST"})
    * @Route("/edit/{id}", name="contact2_edit", methods={"GET", "POST"})
    */
    public function edit(Request $request, Contact $contact = null, EntityManagerInterface $entityManager, ObjectNormalizer $normalizer){
        if(!$contact) {
          $contact = new Contact();
          $entityManager->persist($contact);
        }

        if('POST' === $request->getMethod()) {
          $data = $request->request->all();
          /*
          $data['gender'] = (int) $data['gender'];
          dump($normalizer->denormalize($data, Contact::class));
          exit;

          $serializer->deserialize(json_encode($data), Contact::class, 'json', [
            'object_to_populate' => $contact
          ]);

          dump($contact);
          exit;
          */

          $contact->setFirstname($data['firstname']);
          $contact->setLastname($data['lastname']);
            try{
                $birthday = new \DateTime($data['birthday']);
                $contact->setBirthday($birthday);
            } catch(\Exception $error){}

          $contact->setGender($data['gender']);
            dump($data['phone']);
            exit;

            
          foreach($data['phone'] as $phone){

            $_phone = new Phone();
            $entityManager->persist($_phone);
            $_phone->setNumber($phone);
            $_phone->setContact($contact);
            //$contact->addPhone($_phone);
          }

          $entityManager->flush();
          return $this->redirectToRoute('contact2_index');
        }

      return $this->render('contact2/edit.html.twig', [
        'contact' => $contact,
        'genders' => Contact::GENDERS
      ]);
    }
}
