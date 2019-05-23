<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\ContactRepository;
use App\Repository\PhoneRepository;
use App\Entity\Contact;
use App\Entity\Phone;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/contact2")
 * @IsGranted("ROLE_USER")
 */
class Contact2Controller extends AbstractController
{
    /**
     * @Route("/", name="contact2_index")
     */
    public function index(ContactRepository $contactRepository)
    {
        $contacts = $contactRepository->findBy([
          'created_by' => $this->getUser()
        ]);

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
    public function edit(Request $request, Contact $contact = null, EntityManagerInterface $entityManager, ObjectNormalizer $normalizer, PhoneRepository $phoneRepository){
        //si le contact n'existe pas on instancie un nouveau contact
        // ( nouvel enregistrement en BDD)
        if(!$contact) {
          $contact = new Contact();
          $contact->setCreatedBy($this->getUser());
          // on le persiste pour indiquer à doctrine de le prendre en compte
          $entityManager->persist($contact);
        }
          //MAJ CONTACT
        else {
          $contact->setUpdatedBy($this->getUser());
        }

        // Quand le formulaire est envoyé
        if('POST' === $request->getMethod()) {
          $data = $request->request->all();

          $contact->setFirstname($data['firstname']);
          $contact->setLastname($data['lastname']);
            try{
                $birthday = new \DateTime($data['birthday']);
                $contact->setBirthday($birthday);
            } catch(\Exception $error){}

          $contact->setGender($data['gender']);

          // on sauvegarde les informations en BDD
          $entityManager->flush();
          // on redirige sur la page d'accueil
          return $this->redirectToRoute('contact2_index');
        }

      return $this->render('contact2/edit.html.twig', [
        'contact' => $contact,
        'genders' => Contact::GENDERS
      ]);
    }
}
