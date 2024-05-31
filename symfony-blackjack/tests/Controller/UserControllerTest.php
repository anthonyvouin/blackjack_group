<?php
namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase{
    public function test__createUserLoginAndDelete(): void
    {
        $client = static::createClient();
        $username = uniqid();
        $password = uniqid();

        $body = json_encode([
            'email' => $username . '@test.fr',
            'password' => $password,
            'username' => $username
        ]);

        $client->request('POST', '/user', [], [], ['CONTENT_TYPE' => 'application/json'], $body);
        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        $client->request('POST', '/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => $username,
            'password' => $password,
        ]));

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }
}