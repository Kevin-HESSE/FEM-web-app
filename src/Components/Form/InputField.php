<?php

namespace App\Components\Form;

use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent('inputField', template: 'components/form/inputField.html.twig')]
class InputField
{
    #[ExposeInTemplate]
    public string $type;

    #[ExposeInTemplate]
    public FormView $field;

    #[ExposeInTemplate('required')]
    public bool $isRequired = true;
}