<?php

namespace App\Tests\Functional\Users\Infrastructure\Controller;

use App\Tests\Tools\FixtureTools;
use App\Tests\Tools\LoginTools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    use FixtureTools;
    use LoginTools;

    public function testUserCreatedSuccessfully(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@gmail.com',
                'password' => '12345',
            ])
        );

        $status = $client->getResponse()->getStatusCode();

        $this->assertEquals(200, $status);
    }

    public function testLoginSuccessfully(): void
    {
        $client = static::createClient();
        $user = $this->loadUserFixture();

        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
            ])
        );

        $status = $client->getResponse()->getStatusCode();

        $this->assertEquals(200, $status);
    }

    public function testSocialLoginSuccessfully(): void
    {
        $client = static::createClient();
        $user = $this->loadUserFixture();

        $client->request(
            'POST',
            '/api/social-login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $user->getEmail(),
            ])
        );

        $status = $client->getResponse()->getStatusCode();

        $this->assertEquals(200, $status);
    }

    public function testGetCurrentUser(): void
    {
        $client = static::createClient();
        $user = $this->loadUserFixture();

        $token = $this->createAuthenticatedClient($client, $user->getEmail(), $user->getPassword());

        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $token));

        $client->request('GET', '/api/users/current');

        $userData = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($user->getEmail(), $userData['email']);
    }
}
