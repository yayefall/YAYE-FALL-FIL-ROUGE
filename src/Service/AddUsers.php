<?php
namespace App\Service;

use App\Repository\ProfilsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddUsers
{

    /**
     * @var SerializerInterface
     */
    private $serialize;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    private $encoder;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ProfilsRepository
     */
    private $profilsRepository;


    public function __construct(SerializerInterface $serializer,
                                EntityManagerInterface $em,
                                ValidatorInterface $validator,
                                UserPasswordEncoderInterface $encoder,
                                ProfilsRepository $repo )
    {
        $this->serialize = $serializer ;
        $this->validator = $validator ;
        $this->encoder = $encoder ;
        $this->em = $em ;
        $this->profilsRepository = $repo ;
    }

    /**
     * put image of user
     * @param Request $request
     * @return array|false|resource
     */


    public function uploadImage( $request){
        $photo = $request->files->get("photo");
        if($photo)
        {
            $photoBlob = fopen($photo->getRealPath(),"rb");
            return $photoBlob;
        }
        return null;
    }
    public function validate(){
        return true;
    }









}
