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



}