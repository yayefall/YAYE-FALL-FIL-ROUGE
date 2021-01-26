<?php

namespace App\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Repository\ProfilsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UsersController extends AbstractController
{
    private  $encoder;
    private $serializer;
    private $validator;
    private $profilsRepository;
    private $iriConverter;

    /**
     *
     * @param UserPasswordEncoderInterface $encoder
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param ProfilsRepository $profilsRepository
     * @param IriConverterInterface $iriConverter
     */


    public  function __construct(UserPasswordEncoderInterface $encoder,
                                 SerializerInterface $serializer,
                                 ValidatorInterface $validator,
                                 ProfilsRepository $profilsRepository,
                                 IriConverterInterface $iriConverter)
    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->profilsRepository=$profilsRepository;
        $this->iriConverter=$iriConverter;
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
     * @throws ExceptionInterface
     */
    public function addUsers(Request $request,EntityManagerInterface $manager): JsonResponse
    {

        //recuperer tous les données de la requette
        // $user=$request->request->all();


        //recuperer tous les profils
      //  $profilAll = $this->profilsRepository->findAll();

            $users = $request->request->all();
            // $users = Json_decode($request->getContent(), True);
              // dd($users);
            //la recuperation de l'image
            $photo = $request->files->get('photo');
           // dd($photo);

            //la recuperation de l'riri
            $iriProfil = $this->iriConverter->getItemFromIri($users['profils'])->getLibelle();
        // dd($iriProfil);
            if ($iriProfil === "ADMIN") {

                $user = $this->serializer->denormalize($users, "App\Entity\Admin", true);

            } elseif ($iriProfil === "FORMATEUR" ) {

                $user = $this->serializer->denormalize($users, "App\Entity\Formateur", true);

            } elseif ($iriProfil === "APPRENANT" ) {
                $user = $this->serializer->denormalize($users, "App\Entity\Apprenant", true);

            } elseif($iriProfil === "CM") {
                $user = $this->serializer->denormalize($users, "App\Entity\CM", true);
               // $user->setProfilSortie($this->iriConverter->getItemFromIri($users['profilsortie']));

            }

           //dd($user->getPassword());
       // $profil=$this->iriConverter->getItemFromIri($user['profils']);
      //  $user->setProfils($profil);

            $password = ('password');

            $user->setPassword($this->encoder->encodePassword($user, $password));

            $photob = fopen($photo->getRealPath(), "rb");
             //dd($photob);
        if( $photob) {
            $user->setPhoto($photob);
        }

             $manager->persist($user);
            $manager->flush();
            return $this->json('success', 200);

    }
        /** @Route(
         *     name="editFormateur",
         *     path="/api/admin/users/{id}",
         *     methods={"PUT"},
         * )
         * @param Request $request
         */

        public function editFormatter(Request $request)
        {

        }


    }

