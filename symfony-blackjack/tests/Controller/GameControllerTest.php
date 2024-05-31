<?php
namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase{
    public function test__createGame(): void
    {
        $client = static::createClient();
        $client->request('POST', '/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => 'admin',
            'password' => 'admin',
        ]));

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);
        $jwt = $data['token'];

        $client->request('POST', '/game', [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_Authorization' => 'Bearer '.$jwt]);
        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        // Utilisez le même client pour la deuxième requête
        $client->request('POST', '/game', [], [], ['CONTENT_TYPE' => 'application/json']);
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }
}