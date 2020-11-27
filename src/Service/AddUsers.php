<?php
namespace App\Service;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Repository\ProfilsRepository;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function App\Entity\getPassword;

class AddUsers
{

      /*  private $encoder;
        private $serializer;
        private $validator;
        private $em;
        private $request;
        private $profilsRepository;

        public function __construct(

        UserPasswordEncoderInterface $encoder,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        UsersRepository $usersRepository,
        ProfilsRepository $profilsRepository,
        IriConverterInterface $iriConverter
        )
        {

        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->em=$em;
        $this->usersRepository=$usersRepository;
        $this->profilsRepository=$profilsRepository;
        $this->iriConverter=$iriConverter;
        }

        public function addUser(Request $request)
        {
        $profilAll = $this->profilsRepository->findAll();

        foreach ($profilAll as $value) {

        $user = $request->request->all();



        $photo = $request->files->get("photo");
        $iriProfil = $this->iriConverter->getItemFromIri($user['profils'])->getLibelle();

        if ($iriProfil === $value = "CM"){

        $user = $this->serializer->denormalize($user, "App\Entity\CM", true);

        } elseif ($iriProfil === $value = "ADMIN") {

        $user = $this->serializer->denormalize($user, "App\Entity\Admin", true);

        } elseif ($iriProfil === $value = "FORMATEUR") {

        $user = $this->serializer->denormalize($user, "App\Entity\Formateur", true);

        } elseif($iriProfil===$value="APPRENANT") {

        $user = $this->serializer->denormalize($user, "App\Entity\Apprenant", true);
        $user->setProfilSortie($this->iriConverter->getItemFromIri($user['profilsortie']));
        }

        //$base64 = base64_decode($imagedata);

        if($photo){
            $photoBlob = fopen($photo->getRealPath(), "rb");
            $user->setPhoto($photoBlob);
        }


        $errors = $this->validator->validate($user);
        if (count($errors)) {
        $errors = $this->serializer->serialize($errors, "json");
        return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
        }

        $password =  $user->getPassword();
            $user->setPassword($this->encoder->encodePassword($user, $password));
            $user->setArchivage(0);
        if ($this->encoder->encodePassword($user, $password)) {

        $this->em->persist($user);
        $this->em->flush();

        return new JsonResponse('Authenticated', Response::HTTP_OK);

        } else {

        return new JsonResponse(' username or password not work', Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        }
        }*/


}