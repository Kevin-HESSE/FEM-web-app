<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED', statusCode: 403)]
class ListingController extends AbstractController
{
    /**
     * @param IriConverterInterface $iriConverter
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    #[Route('/', name: 'app_homepage')]
    public function homepage(IriConverterInterface $iriConverter, CategoryRepository $categoryRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if(!$user) {
            return $this->render('account/login.html.twig');
        }

        return $this->render('listing/homepage.html.twig', [
            'formPlaceholder' => 'Search for movies or TV series',
            'currentUser' => $iriConverter->getIriFromResource($user),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @param IriConverterInterface $iriConverter
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    #[Route('bookmarks', name: 'app_listing_bookmark')]
    public function bookmark(IriConverterInterface $iriConverter, CategoryRepository $categoryRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('listing/bookmark.html.twig', [
            'formPlaceholder' => 'Search for movies or TV series',
            'currentUser' => $iriConverter->getIriFromResource($user),
            'categories' => $categoryRepository->findAll(),
        ]);
    }


    /**
     * @param string $slug
     * @param CategoryRepository $categoryRepository
     * @param IriConverterInterface $iriConverter
     * @return Response
     */
    #[Route('/category/{slug}', name: 'app_listing_categories')]
    public function categories(string $slug, CategoryRepository $categoryRepository, IriConverterInterface $iriConverter): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @type Category $category */
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        if( is_null($category)) {
            throw $this->createNotFoundException();
        }

        return $this->render('listing/categories.html.twig', [
            'formPlaceholder' => 'Search for movies or TV series',
            'currentUser' => $iriConverter->getIriFromResource($user),
            'categories' => $categoryRepository->findAll(),
            'currentCategory' => $slug
        ]);
    }
}