<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Repository\ContactRepository;
use App\Repository\PhoneRepository;
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
    public function edit(Request $request, Contact $contact = null, EntityManagerInterface $entityManager, ObjectNormalizer $normalizer, PhoneRepository $phoneRepository){
        //si le contact n'existe pas on instancie un nouveau contact
        // ( nouvel enregistrement en BDD)
        if(!$contact) {
          $contact = new Contact();
          // on le persiste pour indiquer à doctrine de le prendre en compte
          $entityManager->persist($contact);
        }

        // Quand le formulaire est envoyé
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

          // on boucle sur la liste des numeros $phones => tableau contenant
          // number et id
          foreach($data['phone'] as $phone){
            // S'il y a un id dans le tableau $phone c'est que l'enregistrement
            // existe en BDD, on va donc récupérer cet enregistrement
            if(isset($phone['id'])){
                //on récupère le numéro de téléphone en BDD
                $_phone = $phoneRepository->find($phone['id']);
            }
            // Sinon c'est un nouveau numéro de téléphone
            else {
              //on instancie un nouveau numéro de téléphone
              $_phone = new Phone();
              // on le persiste pour indiquer à Doctrine de le prendr
              // en compte
              $entityManager->persist($_phone);
            }
            // on met à jour le numéro dans l'object $_phone
            $_phone->setNumber($phone['number']);
            // on indique que le téléphone appartient à ce contact
            $_phone->setContact($contact);
            //$contact->addPhone($_phone);
          }
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
