<?php

namespace App\Tests\Functional\Users\Infrastructure\Repository;

use App\Tests\Tools\DITools;
use App\Tests\Tools\FakerTools;
use App\Tests\Tools\FixtureTools;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    use FakerTools;
    use DITools;
    use FixtureTools;

    private UserRepository $repository;
    private Generator $faker;
    private AbstractDatabaseTool $databaseTool;
    private UserFactory $userFactory;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->getService(UserRepository::class);
        $this->userFactory = $this->getService(UserFactory::class);
        $this->faker = $this->getFaker();
        $this->databaseTool = $this->getService(DatabaseToolCollection::class)->get();
    }

    public function testUserAddedSuccessfully(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();
        $user = $this->userFactory->create($email, $password);

        $this->repository->add($user);

        $existingUser = $this->repository->findByEmail($user->getEmail());
        $this->assertEquals($user->getEmail(), $existingUser->getEmail());
    }

    public function testUserFoundSuccessfully(): void
    {
        $user = $this->loadUserFixture();

        $existingUser = $this->repository->findByEmail($user->getEmail());

        $this->assertEquals($user->getEmail(), $existingUser->getEmail());
    }
}
