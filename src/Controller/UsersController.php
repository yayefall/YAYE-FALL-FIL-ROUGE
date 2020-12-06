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
use Symfony\Component\Serializer\SerializerInterface;

class UsersController extends AbstractController
{
    private  $encoder;
    private $serializer;
    private $validator;
    private $profilsRepository;
    private $iriConverter;
    /**
     * @var IriConverterInterface
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
     */
    public function addUsers(Request $request,EntityManagerInterface $manager)
    {

        //recuperer tous les données de la requette
        // $user=$request->request->all();


        //recuperer tous les profils
        $profilAll = $this->profilsRepository->findAll();

        foreach ($profilAll as $value) {

            $user = $request->request->all();


            //la recuperation de l'image
            $photo = $request->files->get('photo');
           // dd($photo);
            //la recuperation de l'riri
            $iriProfil = $this->iriConverter->getItemFromIri($user['profils'])->getLibelle();
           // dd($iriProfil);

            if ($iriProfil === $value = "ADMIN") {

                $user = $this->serializer->denormalize($user, "App\Entity\Users", true);

            } elseif ($iriProfil === $value = "FORMATEUR") {

                $user = $this->serializer->denormalize($user, "App\Entity\Formateur", true);

            } elseif ($iriProfil === $value = "APPRENANT") {
                $user = $this->serializer->denormalize($user, "App\Entity\Apprenant", true);

            } elseif($iriProfil === $value = "CM") {
                $user = $this->serializer->denormalize($user, "App\Entity\CM", true);

                $user->setProfilSortie($this->iriConverter->getItemFromIri($user['profilsortie']));
               // dd($user);
            }

           //dd($user->getPassword());
            $password = $user->getPassword();
            $user->setPassword($this->encoder->encodePassword($user, $password));

            $user->setArchivage(0);
            $photob = fopen($photo->getRealPath(), "rb");
             //dd($photob);
            $user->setPhoto($photob);

            $manager->persist($user);
            $manager->flush();
            return $this->json('success', 200);
        }

    }
        /** @Route(
         *     name="editFormateur",
         *     path="/api/admin/users/{id}",
         *     methods={"PUT"},
         * )
         * @param Request $request
         */

        public
        function editFormatter(Request $request)
        {

        }




















    }

