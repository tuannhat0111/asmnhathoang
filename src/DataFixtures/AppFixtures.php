<?php

namespace App\DataFixtures;
use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $ecnoder;

    public function __construct(UserPasswordEncoderInterface $ecnoder)
    {
        $this->encoder =$ecnoder;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Admin();
        // $manager->persist($product);
        $admin->setEmail('abc@gmail.com');
        $admin->setPassword($this ->encoder->encodePassword($admin,'nhathoang'));

        $manager->persist($admin);

        $manager->flush();
    }
}

