<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $hasher;


    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $this->em = $em;
        $this->hasher = $hasher;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function addUser(array $data): array
    {
        try {
            $user = new User();
            $user->setPassword($this->hasher->hashPassword($user, $data['password']));
            $user->setEmail($data['email']);
            $user->setName($data['name']);
            $this->em->persist($user);
            $this->em->flush();

            return ['code' => Response::HTTP_CREATED, 'username' => $user->getUserIdentifier()];
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

}
