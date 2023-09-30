<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_auth_login', methods: ['POST'])]
    public function loginAction(IriConverterInterface $iriConverter, #[CurrentUser] ?User $user): Response
    {
        if(!$user) {
            return $this->json([
                'error' => 'Invalid login request',
            ], 401);
        }

        return new Response(null, 204, [
            'Location' => $iriConverter->getIriFromResource($user),
        ]);
    }

    #[Route('/login', name: 'app_login' , methods: ['GET'])]
    public function login(): Response
    {
        return $this->render('account/authentication/login.html.twig', [
            'isDemo' => $this->getParameter('app.demo')
        ]);
    }

    #[Route('/logout', name: 'app_auth_logout')]
    public function logOut(): never
    {}
}