<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase{


    public function test__createUser(): void
    {

        $client = static::createClient();
        $body = json_encode([
            'email' => 'test@test.fr',
            'password' => 'test111',
            'username' => 'test111'
        ]);

        $client->request('POST', '/user', [], [], ['CONTENT_TYPE' => 'application/json'], $body);
     
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
    
    private static function dataProvider_createUser(): array
    {
        return [
            ['POST', 201],
            ['GET' ]
            ['DELETE']
            ['PATCH'],
            ['PUT']
        ];
    }
}