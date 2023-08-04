<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Used in videoList Component
 */
#[AsTwigComponent('bookmark')]
class Bookmark
{
    public bool $isBookmarked;
}