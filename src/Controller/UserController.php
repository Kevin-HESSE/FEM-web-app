<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'app_user_profile')]
    public function profile(IriConverterInterface $iriConverter, CategoryRepository $categoryRepository): Response
    {
        $user = $this->getUser();

        return $this->render('account/profile.html.twig', [
            'currentUser' => $iriConverter->getIriFromResource($user),
            'categories' => $categoryRepository->findAll(),
            'isDemo' => (bool)$this->getParameter('app.demo')
        ]);
    }
}