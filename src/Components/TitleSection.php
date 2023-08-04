<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('titleSection')]
class TitleSection
{
    public string $content;
}