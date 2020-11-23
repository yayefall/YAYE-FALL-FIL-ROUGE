<?php

namespace App\service;

class MyService
{
    public function Uploading($photo)
    {
        // ajouter  une photo
        return fopen($photo->getRealPath(),"rb");

    }
}


