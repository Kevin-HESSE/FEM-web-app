<?php

namespace App\Components;

use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('navLink')]
class NavLink
{
    public string $image;

    public string $route;

    public ?string $slug = null;

    public string $description;


}