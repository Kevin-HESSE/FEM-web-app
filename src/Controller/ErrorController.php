<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Entity\User;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

/**
 * Replace the default Error Controller.
 */
class ErrorController extends AbstractController
{
    public function show(HttpExceptionInterface $exception, CategoryRepository $categoryRepository): Response
    {
        return $this->render('error.html.twig', [
            'currentUser' => null,
            'categories' => $categoryRepository->findAll(),
            'statusCode' => $exception->getStatusCode(),
        ]);
    }
}