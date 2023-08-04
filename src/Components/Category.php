<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('category')]
class Category
{
    public \App\Entity\Category $category;
}