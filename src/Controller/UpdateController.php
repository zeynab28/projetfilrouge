<?php

namespace App\Controller;

use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Partenaire;
/**
 * @Route("/api")
 */
class UpdateController extends AbstractController
{
    /**
     *@Route("/update/{id}" , name="update" , methods={"PUT"})
     */

    public function index(Request $request, SerializerInterface $serializer, Partenaire $part, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $partUpdate = $entityManager->getRepository(Partenaire::class)->find($part->getId());
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value){
            if($key && !empty($value)) {
                $name = ucfirst($key);
                $setter = 'set'.$name;
                $partUpdate->$setter($value);
            }
        }  
        $errors = $validator->validate($partUpdate);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();
        $data = [
            'status' => 200, 
            'message' => 'Le téléphone a bien été mis à jour'
        ];
        return new JsonResponse($data);
    }
}
