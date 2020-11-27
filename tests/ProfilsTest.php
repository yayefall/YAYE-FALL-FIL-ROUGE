<?php
namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProfilsTest extends WebTestCase
{


    // on se connecte
    protected function createAuthenticatedClient(string $username, string $password): KernelBrowser
    {
        $client = static::createClient();
        $connexion = [
            "username" => $username,
            "password" => $password
        ];
        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($connexion)
        );
        $data = \json_decode($client->getResponse()->getContent(), true);
        $client->setServerParameter('HTTP_Authorization', \sprintf('Bearer %s', $data['token']));

        $client->setServerParameter('CONTENT_TYPE', 'application/json');
        //dd($client);
        return $client;
    }
// on teste la liste de profils

    public function testListProfils()
    {
        $client = $this->createAuthenticatedClient("fsalmon", "password");
        $client->request('GET', '/api/admin/profils');
        $this->assertResponseStatusCodeSame(200);

    }

    //on teste l'affichage d'un profils
   public function testEditProfils()
    {
        $client = $this->createAuthenticatedClient("jean40", "password");
        $client->request('GET', '/api/admin/profils/4');
        //dd($client->getResponse()->getStatusCode());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testCreateProfil()
    {
        $client = $this->createAuthenticatedClient("jean40", "password");
        $client->request(
            'POST',
            '/api/admin/profils',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
              "libelle":"COMMEDIEN",
              "archivage":0
            }'
        );
        $responseContent = $client->getResponse();
        $this->assertResponseStatusCodeSame(200);

    }
// on test la modification d'un profils
    public function testEditProfil()
    {
        $client = $this->createAuthenticatedClient("jean40", "password");
        $client->request(
            'PUT',
            '/api/admin/profils/5',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
              "libelle":"START",
              "archivage":0
            }'
        );
        $responseContent = $client->getResponse();
        $this->assertResponseStatusCodeSame(200);

    }


}

