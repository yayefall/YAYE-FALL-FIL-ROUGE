<?php

namespace App\Controller;

use App\Entity\GroupeCompetence;
use App\Entity\Referentiel;
use App\Repository\GroupeCompetenceRepository;
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

    public  function __construct(
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        GroupeCompetenceRepository $repoGroupeComp
    )
    {
        $this->serializer=$serializer;
        $this->repoGroupeComp=$repoGroupeComp;
        $this->manager=$manager;
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
}
