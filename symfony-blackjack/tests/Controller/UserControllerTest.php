<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();

        // Create 10 users
        for ($i = 0; $i < 10; $i++) {
            $username = uniqid();
            $password = uniqid();

            $body = json_encode([
                'email' => $username . '@test.fr',
                'password' => $password,
                'username' => $username
            ]);

            $this->client->request('POST', '/user', [], [], ['CONTENT_TYPE' => 'application/json'], $body);
            $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        }
    }

    public function tearDown(): void
    {
        $this->client = null;
        parent::tearDown();
    }


    public function test__createUser(): void
    {
        $username = uniqid();
        $password = uniqid();

        $body = json_encode([
            'email' => $username . '@test.fr',
            'password' => $password,
            'username' => $username
        ]);

        $this->client->request('POST', '/user', [], [], ['CONTENT_TYPE' => 'application/json'], $body);
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
    }

    public function test__loginUser(): void
    {
        $username = 'admin';
        $password = 'admin';

        $this->client->request('POST', '/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => $username,
            'password' => $password,
        ]));

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }

    public function test__getUserList(): void
    {
        $this->client->request('POST', '/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => 'admin',
            'password' => 'admin',
        ]));

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);
        $jwt = $data['token'];

        $this->client->request('GET', '/user', ['limit' => 10, 'page' => 1], [], ['HTTP_Authorization' => 'Bearer ' . $jwt]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertIsArray($data);
        $this->assertCount(10, $data);
    }

}