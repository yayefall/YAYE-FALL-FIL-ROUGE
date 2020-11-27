<?php
namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersTest extends WebTestCase
{
   //on se connecte
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

// on teste la liste des Users

    public function testListUsers()
    {
        $client = $this->createAuthenticatedClient("jean40", "password");
        $client->request('GET', '/api/admin/users');
        $this->assertResponseStatusCodeSame(200);

    }
    //on teste l'affichage d'un users
    public function testEditUsers()
    {
        $client = $this->createAuthenticatedClient("fsalmon", "password");
        $client->request('GET', '/api/admin/users/4');
        //dd($client->getResponse()->getStatusCode());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
//on teste la creation d'un users
    public function testCreateUsers()
    {
        $client = $this->createAuthenticatedClient("jean40", "password");
        $client->request(
            'POST',
            '/api/admin/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
              "password": "string",
              "prenom": "string",
              "nom": "string",
              "email": "string",
              "telephone": "string",
              "photo": "image.jpeg",
              "genre": "string",
              "archivage": 0,
              "profils": "/api/admin/profils/2",
  
            }'
        );
        $responseContent = $client->getResponse();
        $this->assertResponseStatusCodeSame(200);

    }





}