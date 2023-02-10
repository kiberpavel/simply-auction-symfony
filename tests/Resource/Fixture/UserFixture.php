<?php

namespace App\Tests\Resource\Fixture;

use App\Tests\Tools\FakerTools;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    use FakerTools;

    public const REFERENCE = 'user';

    public function __construct(private readonly UserFactory $userFactory)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $email = $this->getFaker()->email;
        $password = $this->getFaker()->password;

        $user = $this->userFactory->create($email, $password, User::ROLE_ADMIN);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::REFERENCE, $user);
    }
}
