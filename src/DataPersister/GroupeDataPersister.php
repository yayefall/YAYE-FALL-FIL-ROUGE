<?php

namespace App\DataPersister;



use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Groupe;
use App\Repository\ApprenantRepository;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class GroupeDataPersister  implements DataPersisterInterface
{
   Private $entityManager;
    /*private $apprenantrepository;
    private $grouperepository;*/

    public function __construct(EntityManagerInterface $entityManager,
    ApprenantRepository $apprenantrepository ,GroupeRepository $grouperepository,
    RequestStack $requeststack)
    {
        $this->entityManager=$entityManager;
      /*  $this->apprenantrepository= $apprenantrepository;
        $this->grouperepository=$grouperepository;
*/

    }

    public function supports($data): bool
    {
        return $data instanceof Groupe;
    }

    public function persist($data,array $context = [])
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data,array $context = [])
    {
        $data->setArchivage(1);
        $this->entityManager->flush();
        return $data;
    }
}
