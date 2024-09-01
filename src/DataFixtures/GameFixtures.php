<?php

namespace App\DataFixtures;

use App\Entity\Game;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker;

class GameFixtures extends Fixture
{
    /** @throws Exception */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 20; $i++) {
                        $game = (new Game())
                            ->setName($faker->company())
                            ->setDescription($faker->text())
                            ->setPrice($faker->int())
                            ->setCreatedAt(new DateTimeImmutable());

                        $manager->persist($game);
                        $this->addReference("game$i", $game);
                    }

        $manager->flush();
    }
}
