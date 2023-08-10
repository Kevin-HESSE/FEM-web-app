<?php

namespace App\Model;

class FilmInformation
{

    public function __construct(
        private int $id,
        private bool $isBookmarked
    )
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isBookmarked(): bool
    {
        return $this->isBookmarked;
    }

    /**
     * @param bool $isBookmarked
     */
    public function setIsBookmarked(bool $isBookmarked): void
    {
        $this->isBookmarked = $isBookmarked;
    }
}