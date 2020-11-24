<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\VarDumper\Cloner\Data;

class UsersController extends AbstractController
{
    private  $encoder;
    private $serializer;
    private $validator;

    public  function __construct(UserPasswordEncoderInterface $encoder,
                                 SerializerInterface $serializer,
                                 ValidatorInterface $validator)
    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
    }



    /**
     * @Route(
     *     name="addFormateur",
     *     path="/api/admin/formateurs",
     *     methods={"POST"},
     * )
     *
     *
     * @Route(
     *     name="addCm",
     *     path="/api/admin/cms",
     *     methods={"POST"},
     * )
     *
     *
     * @Route(
     *     name="addApprenant",
     *     path="/api/admin/apprenants",
     *     methods={"POST"},
     * )
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     *
     * @Route(
     *     name="addUser",
     *     path="/api/admin/users",
     *     methods={"POST"},
     * )
     */
    public function addUsers(Request $request,EntityManagerInterface $manager)
    {
        //recuperer tous les données de la requette
        $user=$request->request->all();
        //la recuperation de l'image
        $photo=$request->files->get('photo');
       // $photo=$MyService->Uploading($request->files->get("photo"));

        if ($user['profils']==="App/Admin/Profils/1"){
            $user=$this->serializer->denormalize($user,"App\Entity\Users",true);
        }
        elseif ($user['profils']==="App/Admin/Profils/2"){
            $user=$this->serializer->denormalize($user,"App\Entity\Formateur",true);
           }
           elseif($user['profils']==="App/Admin/Profils/3"){
               $user=$this->serializer->denormalize($user,"App\Entity\Apprenant",true);
           }
           else {
               $user = $this->serializer->denormalize($user, "App\Entity\CM", true);
           }

        $password="password";
        $user->setPassword($this->encoder->encodePassword($user, $password));
        $user->setArchivage(0);
        $photob=fopen($photo->getRealPath(),"rb");

        $user->setPhoto($photob);

        $manager->persist($user);
        $manager->flush();
        return $this->json('success',200);
    }


    /** @Route(
     *     name="editFormateur",
     *     path="/api/admin/users/{id}",
     *     methods={"PUT"},
     * )
     * @param Request $request
     */

    public function editFormatter(Request $request){

        $user=$request->request->findAll();
        dd($user);
    }
}
