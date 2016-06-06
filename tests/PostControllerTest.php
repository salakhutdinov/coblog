<?php

namespace tests;

use Coblog\Security\AuthManager;
use Coblog\Model\User;

class PostControllerTest extends WebTestCase
{
    public function testNewPost()
    {
        $client = static::createClient();

        $response = $client->request('GET', '/new');
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertArrayHasKey('Location', $response->getHeaders());
        $this->assertEquals('/', $response->getHeaders()['Location']);

        // mock auth manager
        $app = $client->getKernel();
        $authManager = $this->createMock(AuthManager::class);
        $authManager->method('isLoggedIn')->willReturn(true);
        $authManager->method('getCurrentUser')->willReturn(new User('testuser@example.com', 'pwd'));
        $app['auth_manager'] = $authManager;

        $response = $client->request('GET', '/new');
        $this->assertEquals(200, $response->getStatusCode());

        $postData = [
            'title' => 'test_post_title',
            'text' => 'test_post_text',
        ];
        $response = $client->request('POST', '/new', [], $postData);
        $this->assertEquals(302, $response->getStatusCode());

        $response = $client->request('GET', $response->getHeaders()['Location']);
        $this->assertContains($postData['title'], $response->getContent());
        $this->assertContains($postData['text'], $response->getContent());
    }
}
