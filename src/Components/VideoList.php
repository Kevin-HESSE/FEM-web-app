<?php

namespace App\Components;

use App\Repository\VideoRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('videoList')]
class VideoList
{
    public string $title;

    public bool $isTrending = false;

    public ?array $videos = null;

    public VideoRepository $videoRepository;

    /**
     * @param VideoRepository $videoRepository
     */
    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        if(array_key_exists('isTrending', $data) && $data['isTrending'] ){
            $data['videos'] = $this->videoRepository->findBy(['isTrending' => true]);
        }

        return $data;
    }
}