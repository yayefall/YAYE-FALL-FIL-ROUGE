<?php

namespace App\Controller;

use App\Entity\GroupeCompetence;
use App\Entity\Referentiel;
use App\Repository\GroupeCompetenceRepository;
use App\Service\AddUsers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ReferentielController extends AbstractController
{
    private $serializer;
    private $manager;
    private $repoGroupeComp;
    /**
     * @var AddUsers
     */
    private $userService;

    public  function __construct(
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        GroupeCompetenceRepository $repoGroupeComp,
        AddUsers $userService
    )
    {
        $this->serializer=$serializer;
        $this->repoGroupeComp=$repoGroupeComp;
        $this->manager=$manager;
        $this->userService=$userService;
    }
    /**
     * @Route("api/admin/referentiels",
     *      name="referentiel",
     *     methods={"POST"})
     */

    public function addReferentiel(Request $request)
    {
        $ReferenceTAb= $request->request->all();
        $programme= $request->files->get("programme");
        if ($programme != null) {
            $programmes = fopen($programme->getRealPath(), 'rb');
        }

        $reference=$this->serializer->denormalize($ReferenceTAb,Referentiel::class,'json');
        $reference->setProgramme($programmes);
        foreach ($ReferenceTAb['groupeCompetence'] as $groupeCompetence){
            $groupe= $this->manager->getRepository(GroupeCompetence::class)->find($groupeCompetence);
            $reference->addGroupeCompetence($groupe);
        }
        $this->manager->persist($reference);
        $this->manager->flush();

        return new JsonResponse("Successfull",Response::HTTP_CREATED);
    }


    /**
     * @Route(
     *     "api/admin/referentiels/{id}",
     *      name="referentiel",
     *      methods={"PUT"})
     *
     * @param EntityManagerInterface $manager
     * @param int $id
     * @param Request $request
     * @return Response
     */



    public function put(EntityManagerInterface $manager, int $id, Request $request): Response
    {

        $Referentiel = $manager->getRepository(Referentiel::class)->find($id);
      //  dd($Referentiel);
        $requestAll = $request->request->all();
        $reference=$this->serializer->denormalize($requestAll,Referentiel::class,'json');
        // dd($requestAll);
        foreach ($requestAll as $key=>$value){
            if($key !="_method" || !$value ){
                // dd($key);

                if($key == 'libelle' || $key == 'presentation' || $key == 'critereAdmission' || $key == 'critereEvaluation'){
                    $method="set".ucfirst($key);
                    $Referentiel->$method($value);
                }
                foreach ($requestAll['groupeCompetence'] as $groupeCompetence){
                    $groupe= $this->manager->getRepository(GroupeCompetence::class)->find($groupeCompetence);
                    if($key == 'groupeCompetence'){
                        $reference->addGroupeCompetence($groupe);
                    }
                }
                $this->manager->persist($Referentiel);
                $this->manager->flush();
                $message = 'modification succesfull';

            }
        }
        $programme = $request->files->get("programme");
        if($programme)
        {
            $photo = fopen($programme->getRealPath(),"rb");
            $Referentiel->setProgramme($photo);
            $this->manager->persist($Referentiel);
            $this->manager->flush();
            $message = 'succesfull';
        }



        if (!$message){
            return new JsonResponse('erreur ngay amm fofou deee',Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse($message,Response::HTTP_OK);
    }
}
