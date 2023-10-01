<?php

namespace App\DataFixtures;

use App\Entity\ActivityArea;
use App\Entity\ContractType;
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

    private const CONTRACT_TYPES = ["CDI", "CDD", "Intérim"];

    private const ACTIVITY_AREA = ["RH", "Informatique", "Comptabilité", "Direction"];
    public function load(ObjectManager $manager): void
    {

        //$activityAreaRepository = $manager->getRepository(ActivityArea::class);
        //$activityArea = $activityAreaRepository->findOneBy(['sector' => '']);

        $faker = \Faker\Factory::create("fr_FR");

        $contractTypes = [];

        foreach (self::CONTRACT_TYPES as $contractTypeName) {
          $contractType = new ContractType();
          $contractType->setName($contractTypeName);
          $manager->persist($contractType);
          $contractTypes[] = $contractType;
        }

        $activityAreas = [];

        foreach (self::ACTIVITY_AREA as $activityAreaName) {
          $activityArea = new ActivityArea();
          $activityArea->setName($activityAreaName);
          $manager->persist($activityArea);
          $activityAreas[] = $activityArea;
        }

        for ($i = 0; $i < self::NB_EMPLOYEES; $i++){
            $regularUser = new User();
            $regularUser
                ->setEmail($faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->passwordEncoder->encodePassword($regularUser, 'password'))
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setContractType($faker->randomElement($contractTypes))
                ->setActivityArea($faker->randomElement($activityAreas))
                ;

            $manager->persist($regularUser);
            $employees[] = $regularUser;
        }

            $adminUser = new User();
            $adminUser
                ->setEmail('admin@mycorp.com')
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword($this->passwordEncoder->encodePassword($adminUser, 'quentin'))
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setContractType($faker->randomElement($contractTypes))
                ->setActivityArea($faker->randomElement($activityAreas))
                ;
            $manager->persist($adminUser);
        
        $manager->flush();
}
}
