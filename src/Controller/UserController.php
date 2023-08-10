<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Model\FilmInformation;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/action/bookmark', name: 'app_user_bookmark', methods: 'POST')]
    public function bookmarkAction(Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$this->getUser()) {
            return $this->json([
                'message' => 'Page not found'
            ], status: 404);
        }

        $content = $request->toArray();

        $filmInformation = new FilmInformation($content['id'], filter_var($content['isBookmarked'], FILTER_VALIDATE_BOOLEAN));

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $video = $entityManager->getRepository(Video::class)->findOneBy(['id' => $filmInformation->getId()]);

        if(!$video) {
            return $this->json([
                'message' => 'Video not found'
            ], status: 404);
        }

        !$filmInformation->isBookmarked() ? $video->addUser($currentUser) : $video->removeUser($currentUser);

        try {
            $entityManager->flush();
            $status = 200;
            $message = 'Ok';
        } catch (\Exception $exception) {
            echo 'Exception catched : ', $exception->getMessage(), '\n';
            $message = 'An error has occured, try later';
            $status = 500;
        }

        return $this->json([
            'message' => $message
        ], status: $status);
    }
}