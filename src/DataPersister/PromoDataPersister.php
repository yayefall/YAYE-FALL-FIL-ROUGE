<?php

namespace App\DataPersister;



use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Promo;
use Doctrine\ORM\EntityManagerInterface;


class PromoDataPersister  implements DataPersisterInterface
{
    Private $entityManager;


    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;
    }

    public function supports($data): bool
    {
        return $data instanceof Promo;
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
