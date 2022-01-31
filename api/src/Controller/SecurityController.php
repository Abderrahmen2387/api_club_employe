<?php

namespace App\Controller;

use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function login(JWTTokenManagerInterface $JWTManager): Response
    {
        $user = $this->getUser();

        return $this->json([
            'accessToken' => $JWTManager->create($user),
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles()
        ]);
    }

    /**
     * @Route("/api/logout", name="api_logout", methods={"POST"})
     */
    public function logout()
    {
    }

    /**
     * @param Request $request
     * @param UserService $userService
     * @return mixed
     *
     * @Route("/api/register", name="api_register", methods={"POST"})
     * @throws \Exception
     */
    public function register(
        Request $request,
        UserService $userService
    ) {
        return $this->json($userService->addUser(json_decode($request->getContent(), true)));
    }
}
