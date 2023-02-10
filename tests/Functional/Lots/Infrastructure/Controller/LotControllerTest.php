<?php

namespace App\Tests\Functional\Lots\Infrastructure\Controller;

use App\Tests\Tools\FixtureTools;
use App\Tests\Tools\LoginTools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LotControllerTest extends WebTestCase
{
    use LoginTools;
    use FixtureTools;

    public function testCreateNeLotSuccessfully(): void
    {
        @touch(__DIR__.'/test.png');

        $photo = new UploadedFile(
            __DIR__.'/test.png',
            'test.png',
            'image/png');
        $client = static::createClient();

        $user = $this->loadUserFixture();

        $token = $this->createAuthenticatedClient($client, $user->getEmail(), $user->getPassword());
        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $token));

        $client->request(
            'POST',
            '/api/lot/create',
            [],
            ['lot_image' => $photo],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'user_id' => $user->getId(),
                'short_name' => 'test name',
                'price' => 2.3,
                'description' => 'Test description',
                'end_trade_time' => '2023-01-21 08:26:26',
            ])
        );

        $status = $client->getResponse()->getStatusCode();

        $this->assertEquals(200, $status);
    }
}
