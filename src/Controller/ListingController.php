<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Video;
use App\Model\VideoInformation;
use App\Repository\CategoryRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED', statusCode: 403)]
class ListingController extends AbstractController
{
    /**
     * @var VideoRepository
     */
    private VideoRepository $videoRepository;

    /**
     * @param VideoRepository $videoRepository
     */
    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'app_homepage')]
    public function homepage(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if($request->isMethod('POST') && $request->request->get('filter') !== ''){
            $searchTerm = $request->request->get('filter');
            $filteredResult = $this->videoRepository->findTitleByTerm($searchTerm, $user);
            $textResult = 'Found ' . count($filteredResult). ' results for \''. $searchTerm. '\'';

            return $this->render('listing/search.html.twig',[
                'videos' => $filteredResult,
                'searchTerm' => $searchTerm,
                'textResult' => $textResult
            ]);
        }

        $videos = $this->videoRepository->findAllVideoWithUserBookmarks($user);

        return $this->render('listing/homepage.html.twig', [
            'formPlaceholder' => 'Search for movies or TV series',
            'videos' => $videos
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('bookmarks', name: 'app_listing_bookmark')]
    public function bookmark(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if($request->isMethod('POST') && $request->request->get('filter') !== ''){
            $searchTerm = $request->request->get('filter');
            $filteredResult = $this->videoRepository->findBookmarkTitleByTerm($searchTerm, $user);
            $textResult = 'Found ' . count($filteredResult). ' results for \''. $searchTerm. '\'';

            return $this->render('listing/search.html.twig',[
                'videos' => $filteredResult,
                'searchTerm' => $searchTerm,
                'textResult' => $textResult
            ]);
        }

        $videos = $this->videoRepository->findAllBookmarkedVideoForUser($user);

        return $this->render('listing/bookmark.html.twig', [
            'formPlaceholder' => 'Search for bookmarked shows',
            'videos' => $videos
        ]);
    }


    /**
     * @param CategoryRepository $categoryRepository
     * @param string $slug
     * @param Request $request
     * @return Response
     */
    #[Route('/category/{slug}', name: 'app_listing_categories')]
    public function categories(CategoryRepository $categoryRepository, string $slug, Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @type Category $category */
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        if($request->isMethod('POST') && $request->request->get('filter') !== ''){
            $searchTerm = $request->request->get('filter');
            $filteredResult = $this->videoRepository->findTitleByTermAndCategory($searchTerm, $category);
            $textResult = 'Found ' . count($filteredResult). ' results for \''. $searchTerm. '\'';

            return $this->render('listing/search.html.twig',[
                'videos' => $filteredResult,
                'searchTerm' => $searchTerm,
                'textResult' => $textResult,
                'slug' => $slug
            ]);
        }

        $formPlaceholder = 'Search for '. strtolower($category->getName());

        $videos = $this->videoRepository->findAllVideosWithUserBookmarksByCategory($user, $category);

        return $this->render('listing/categories.html.twig', [
            'formPlaceholder' => $formPlaceholder,
            'videos' => $videos,
            'slug' => $slug
        ]);
    }
}