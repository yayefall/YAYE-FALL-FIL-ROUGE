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
     * @param string|null $fileName
     * @return array|false|resource
     *
     */


   /* public function PutUser(Request $request,string $fileName = null){
        $raw =$request->getContent();

        //    dd($raw);
        $delimiteur = "multipart/form-data; boundary=";
        $ok=explode($delimiteur,$request->headers->get("content-type"))[0];
        $boundary= "--" . $ok;
        $elements = str_replace([$boundary,'Content-Disposition: form-data;',"name="],"",$raw);
        //dd($boundary);
        $elementsTab = explode("\r\n\r\n",$elements);
        // dd($elementsTab);
        $data =[];
        for ($i=0;isset($elementsTab[$i+1]);$i+=2){
            // dd($elementsTab[$i+1]);
            $key = str_replace(["\r\n",' "','"'],'',$elementsTab[$i]);
            // dd($key);
            if (strchr($key,$fileName)){
                $stream =fopen('php://memory','r+');
                // dd($stream);
                fwrite($stream,$elementsTab[$i +1]);
                rewind($stream);
                $data[$fileName] = $stream;
                // dd($data);
            }else{
                $val=$elementsTab[$i+1];
                $val = str_replace(["\r\n", "--"],'',($elementsTab[$i+1]));
                //dd($val);
                $data[$key] = $val;
                // dd($data[$key]);
            }
        }
        //dd($data);
        // dd($data["profils"]);
        if (isset($data["profils"])) {
            $prof=$this->profilsRepository->findOneBy(['libelle'=>$data["profils"]]);
            $data["profils"] = $prof;
        }

        // dd($prof);
        return $data;

    }*/














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
