<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Profils;
use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Service\AddUsers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class PutUserController extends AbstractController
{
    /**
     * @var AddUsers
     */
    private $userService;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    private $serializer;
    private $validator;
    private $uploadImage;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public  function __construct(AddUsers $userService,
                                 EntityManagerInterface $em,
                                 SerializerInterface $serializer,
                                 ValidatorInterface $validator,
                                 UserPasswordEncoderInterface $encoder)
{

    $this->userService=$userService;
    $this->em=$em;
    $this->serializer=$serializer;
    $this->validator=$validator;
    $this->encoder=$encoder;
}


    /**
     * @Route(
     *     name="putFormateur",
     *     path="/api/admin/formateurs/{id}",
     *     methods={"PUT"},
     * )
     *
     *
     * @Route(
     *     name="putCm",
     *     path="/api/admin/cms/{id}",
     *     methods={"PUT"},
     * )
     *
     *
     * @Route(
     *     name="putApprenant",
     *     path="/api/admin/apprenants/{id}",
     *     methods={"PUT"},
     * )
     *
     * @param EntityManagerInterface $em
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     *
     * @Route(
     *     name="putUser",
     *     path="/api/admin/users/{id}",
     *     methods={"PUT"},
     *     defaults={
     *          "__controller"="App\Controller\UsersController::put",
     *          "__api_resource_class"=Users::class,
     *          "__api_collection_operation_name"="put_user"
     *     }
     *   )
     */

   /* public function putusers ($id,AddUsers $service,Request $request,
                                UsersRepository $repo,
                                EntityManagerInterface $em,
                                UserPasswordEncoderInterface $encoder): JsonResponse
    {
        $user=$service->PutUser($request,'photo');
       // dd($user);
        $utilisateurs=$repo->find($id);

        // dd($utilisateurs);
        foreach ($user as $key => $valeur) {
            $setter='set'.ucfirst(strtolower($key));
            // dd($setter);
            if(method_exists(Users::class, $setter)){
                if($setter=='setProfils'){
                    $utilisateurs->setProfils($user["profils"]);
                }
                else{
                    // dd($valeur);
                    $utilisateurs->$setter($valeur);
                }

            }
            if ($setter=='setPassword'){
                // dd($encoder);
                $utilisateurs->setPassword($encoder->encodePassword($utilisateurs,$user['password']));
                // dd($encoder);

            }
        }
        //dd($utilisateur);
        $em->persist($utilisateurs);
        $em->flush();
        return new JsonResponse("MODIFICATION AVEC SUCCES",200,[],true);
    }*/

















    public function put(EntityManagerInterface $em, int $id, Request $request): Response
    {
        $user = $em->getRepository(Users::class)->find($id);
       // dd($user);
        $requestAll = $request->request->all();
        // dd($requestAll);
        foreach ($requestAll as $key=>$value){
            if($key !="_method" || !$value ){
               // dd($key);

                    $method="set".ucfirst($key);
                    $user->$method($value);
                $this->em->persist($user);
                $this->em->flush();
                $message = 'modification succesfull';

            }
        }
        $photo= $this->userService->uploadImage($request);

    if($photo){
        $user->setPhoto($photo);
        $this->em->persist($user);
        $this->em->flush();
        $message = 'succesfull';
    }
           // return new JsonResponse('successful of modification',Response::HTTP_OK);
      /*  $errors = $this->validator->validate($user);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }*/

        if (!$message){
            return new JsonResponse('erreur ngay amm fofou deee',Response::HTTP_BAD_REQUEST);
        }
         return new JsonResponse($message,Response::HTTP_OK);

    }






}
