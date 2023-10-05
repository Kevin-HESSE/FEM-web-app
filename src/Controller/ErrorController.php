<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Replace the default Error Controller.
 */
class ErrorController extends AbstractController
{
    public function show(HttpExceptionInterface $exception, CategoryRepository $categoryRepository, IriConverterInterface $iriConverter): Response
    {
        $user = $this->getUser();

        return $this->render('error.html.twig', [
            'currentUser' => $iriConverter->getIriFromResource($user),
            'categories' => $categoryRepository->findAll(),
            'statusCode' => $exception->getStatusCode(),
        ]);
    }
}