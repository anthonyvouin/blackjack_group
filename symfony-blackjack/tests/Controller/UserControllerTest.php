<?php
namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase{
    private $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function tearDown(): void
    {
        $this->client = null;
        parent::tearDown();
    }

    public function test__createUserLoginAndDelete(): void
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

        $this->client->request('POST', '/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => $username,
            'password' => $password,
        ]));

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }
}