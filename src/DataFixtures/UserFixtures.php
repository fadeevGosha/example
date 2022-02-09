<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixtures
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->create(User::class, function (User $user) use ($manager)
        {
            $user
                ->setEmail('admin@mail.ru')
                ->setFirstName('Администратор')
                ->setPassword($this->passwordEncoder->encodePassword($user, '12345678'))
                ->setRoles([User::USER_ROLE, User::ADMIN_ROLE]);

            $manager->persist(new ApiToken($user));
        });

        $this->createMany(User::class, 10, function (User $user) use ($manager)
        {
            $user
                ->setEmail($this->faker->email)
                ->setFirstName($this->faker->name)
                ->setPassword($this->passwordEncoder->encodePassword($user, '12345678'))
                ->setRoles([User::USER_ROLE]);

            $manager->persist(new ApiToken($user));
       });
    }
}