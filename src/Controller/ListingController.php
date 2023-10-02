<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED', statusCode: 403)]
class ListingController extends AbstractController
{
    /**
     * @var VideoRepository
     */
    private VideoRepository $videoRepository;
    private CategoryRepository $categoryRepository;

    /**
     * @param VideoRepository $videoRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(VideoRepository $videoRepository, CategoryRepository $categoryRepository)
    {
        $this->videoRepository = $videoRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param IriConverterInterface $iriConverter
     * @return Response
     */
    #[Route('/', name: 'app_homepage')]
    public function homepage(IriConverterInterface $iriConverter): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if(!$user) {
            return $this->render('account/authentication/login.html.twig');
        }

        return $this->render('listing/homepage.html.twig', [
            'formPlaceholder' => 'Search for movies or TV series',
            'currentUser' => $iriConverter->getIriFromResource($user),
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    /**
     * @param IriConverterInterface $iriConverter
     * @return Response
     */
    #[Route('bookmarks', name: 'app_listing_bookmark')]
    public function bookmark(IriConverterInterface $iriConverter): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('listing/bookmark.html.twig', [
            'formPlaceholder' => 'Search for movies or TV series',
            'currentUser' => $iriConverter->getIriFromResource($user),
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }


    /**
     * @param CategoryRepository $categoryRepository
     * @param string $slug
     * @param Request $request
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
            'categories' => $this->categoryRepository->findAll(),
            'currentCategory' => $slug
        ]);
    }
}