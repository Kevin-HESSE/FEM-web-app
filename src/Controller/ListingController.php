<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListingController extends AbstractController
{
    private VideoRepository $videoRepository;

    /**
     * @param VideoRepository $videoRepository
     */
    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    #[Route('/', name: 'app_homepage')]
    public function homepage(Request $request): Response
    {
        if($request->isMethod('POST' && $request->request->get('filter') !== '')){
            $searchTerm = $request->request->get('filter');
            $filteredResult = $this->videoRepository->findTitleByTerm($searchTerm);
            $textResult = 'Found ' . count($filteredResult). ' results for \''. $searchTerm. '\'';

            return $this->render('listing/search.html.twig',[
                'videos' => $filteredResult,
                'searchTerm' => $searchTerm,
                'textResult' => $textResult
            ]);
        }

        $videos = $this->videoRepository->findBy(['isTrending' => false]);

        return $this->render('listing/homepage.html.twig', [
            'formPlaceholder' => 'Search for movies or TV series',
            'videos' => $videos
        ]);
    }

    #[Route('bookmarks', name: 'app_listing_bookmark')]
    public function bookmark(Request $request): Response
    {
        if($request->isMethod('POST') && $request->request->get('filter') !== ''){
            $searchTerm = $request->request->get('filter');
            $filteredResult = $this->videoRepository->findTitleByTerm($searchTerm, 'bookmarked');
            $textResult = 'Found ' . count($filteredResult). ' results for \''. $searchTerm. '\'';

            return $this->render('listing/search.html.twig',[
                'videos' => $filteredResult,
                'searchTerm' => $searchTerm,
                'textResult' => $textResult
            ]);
        }

        $videos = $this->videoRepository->findBy(['isBookmarked' => true]);

        return $this->render('listing/bookmark.html.twig', [
            'formPlaceholder' => 'Search for bookmarked shows',
            'videos' => $videos
        ]);
    }

    #[Route('/category/{slug}', name: 'app_listing_categories')]
    public function categories(CategoryRepository $categoryRepository, string $slug, Request $request): Response
    {
        /** @type Category $category */
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        if($request->isMethod('POST') && $request->request->get('filter') !== ''){
            $searchTerm = $request->request->get('filter');
            $filteredResult = $this->videoRepository->findTitleByTermAndCategory($searchTerm, $category->getId());
            $textResult = 'Found ' . count($filteredResult). ' results for \''. $searchTerm. '\'';

            return $this->render('listing/search.html.twig',[
                'videos' => $filteredResult,
                'searchTerm' => $searchTerm,
                'textResult' => $textResult,
                'slug' => $slug
            ]);
        }

        $formPlaceholder = 'Search for '. strtolower($category->getName());

        $videos = $this->videoRepository->findBy(['category' => $category->getId()]);

        return $this->render('listing/categories.html.twig', [
            'formPlaceholder' => $formPlaceholder,
            'videos' => $videos,
            'slug' => $slug
        ]);
    }
}