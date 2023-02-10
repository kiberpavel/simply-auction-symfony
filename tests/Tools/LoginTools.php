<?php

namespace App\Tests\Tools;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait LoginTools
{
    public function createAuthenticatedClient(KernelBrowser $client, string $email, string $password): string
    {
        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $email,
                'password' => $password,
            ])
        );
        $data = json_decode($client->getResponse()->getContent(), true);

        return $data['token'];
    }
}
