<?php

namespace App\DataFixtures;

use App\Factory\AuthorFactory;
use App\Factory\BookFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        AuthorFactory::createMany(10);

        UserFactory::createOne([
            'email' => 'me_admin@ums.com',
            'roles' => ['ROLE_ADMIN']
        ]);
        UserFactory::createOne([
            'email' => 'me_user@ums.com',
        ]);
        UserFactory::createMany(10);
        BookFactory::createMany(100, [
            'author' => AuthorFactory::random(),
        ]);

        $manager->flush();
    }
}
