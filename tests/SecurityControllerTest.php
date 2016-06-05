<?php

namespace tests;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $response = $client->request('GET', '/login');
        $this->assertContains('Login form', $response->getContent());
        $this->assertNotContains('Bad credentials', $response->getContent());
        
        $authData = [
            'login' => 'test@example.com',
            'password' => '123',
        ];
        $response = $client->request('POST', '/login', [], $authData);
        $this->assertContains('Bad credentials', $response->getContent());

        $authData['password'] = 'test';
        $response = $client->request('POST', '/login', [], $authData);
        $this->assertArrayHasKey('Location', $response->getHeaders());
        $this->assertEquals('/', $response->getHeaders()['Location']);
    }
}
