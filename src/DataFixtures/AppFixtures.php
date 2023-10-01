<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    private const NB_EMPLOYEES = 10;
    public function load(ObjectManager $manager): void
    {

        //$activityAreaRepository = $manager->getRepository(ActivityArea::class);
        //$activityArea = $activityAreaRepository->findOneBy(['sector' => '']);

        $faker = \Faker\Factory::create("fr_FR");

        $employees = [];

        for ($i = 0; $i < self::NB_EMPLOYEES; $i++){
            $regularUser = new User();
            $regularUser
                ->setEmail($faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->passwordEncoder->encodePassword($regularUser, 'password'))
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                //->setActyvityArea('RH')
                //->setActivityArea($activityArea->getSector)
                ->setContractType('CDI');

            $manager->persist($regularUser);
            $employees[] = $regularUser;
        }

            $adminUser = new User();
            $adminUser
                ->setEmail('admin@mycorp.com')
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->passwordEncoder->encodePassword($adminUser, 'quentin'))
                //->setPassword('quentin')
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                //->setActyvityArea('RH')
                ->setContractType('CDI');

            $manager->persist($adminUser);
        
        $manager->flush();
}
}
