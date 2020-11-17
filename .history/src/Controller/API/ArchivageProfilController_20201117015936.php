<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArchivageProfilController extends AbstractController
{
    /**
     * @Route("/archivage/profil", name="archivage_profil")
     */
    public function index(): Response
    {
        return $this->render('archivage_profil/index.html.twig', [
            'controller_name' => 'ArchivageProfilController',
        ]);
    }
}
