<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Compte;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Utilisateur;
use App\Entity\Partenaire;

use App\Controller\PartenaireRepository;

/**
 * @Route("/api")
 */
class NeldamController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $values = json_decode($request->getContent());
       
        if(isset($values->username,$values->password)) {
            $utilisateur = new Utilisateur();
            $utilisateur->setUsername($values->username);
            $utilisateur->setPassword($passwordEncoder->encodePassword($utilisateur, $values->password));
            $utilisateur->setRoles(array('ROLE_ADMIN'));
            $utilisateur->setPrenom($values->prenom);
            $utilisateur->setNom($values->nom);
            $utilisateur->setTel($values->tel);
            $utilisateur->setProfile($values->profile);
            
            $errors = $validator->validate($utilisateur);

            if(count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Type' => 'application/json'
                ]);
            }
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            $data = [
                'statu' => 201,
                'messag' => 'L\'utilisateur a été créé'
            ];

            return new JsonResponse($data, 201);
        }
        $data = [
            'statu' => 500,
            'messag' => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($data, 500);
    }
    /**
     * @Route("/login_check", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }
       /**
     * @Route("/ajout", name="ajout", methods={"POST"})
     */
    public function ajout(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager,SerializerInterface $serializer, ValidatorInterface $validator )
    {
        $values = json_decode($request->getContent());
        if(isset($values->ninea,$values->raison_sociale)) {
            $part = new Partenaire();
        
            
    
            $part->setRaisonSociale($values->raison_sociale);
            $part->setNinea($values->ninea);
            $part->setAdresse($values->adresse);
            $part->setPhone($values->phone);
            $part->setEmail($values->email);

            $p=$this->getDoctrine()->getRepository(Utilisateur::class);
            $parti=$p->find($values->utilisateur);
            $part->setUtilisateur($parti);
            var_dump($values);
            
             $errors = $validator->validate($partenaire);

            if(count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Type' => 'application/json'
                ]);
            }
            $entityManager->persist($part);
            $entityManager->flush();
            $dat = [
                'status' => 201,
                'messages' => 'Le partenaire a été créé'
            ];
            return new JsonResponse($dat, 201);
        }
        $dat = [
            'status' => 500,
            'message' => 'Le partenaire n\'a pas été créé'
        ];
        return new JsonResponse($dat, 500);
    }
    /**
    * @Route("/depot" , name="depot" , methods={"POST"})
    */
    public function depot(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    { 
        $depot = $serializer->deserialize($request->getContent(), Depot::class, 'json');
        $entityManager->persist($depot);
        $entityManager->flush();
        $da = [
            'statuss' => 201,
            'messagee' => 'Le depot a bien été bien fait'
        ];
            return new JsonResponse($da, 201);
        }
        /**
         *@Route("/compte" , name="compte" , methods={"POST"})
         */
        public function compte(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager)
        { 
            $compte = $serializer->deserialize($request->getContent(), Compte::class, 'json');
            $inse=$this->getDoctrine()->getRepository( Partenaire::class);
            $inser=$inse->find($compte->utilisateur_id);
            $compte->setUtilisateur($inser);
            $entityManager->persist($compte);
            $entityManager->flush();
            $d = [  
                'statusss' => 201,
            'messageee' => 'Le compte a bien été ajouté'
        ];
        return new JsonResponse($d, 201);
    }

     
}