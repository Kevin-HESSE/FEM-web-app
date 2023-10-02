<?php

namespace App\State;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserHashPasswordProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: PersistProcessor::class )] private readonly ProcessorInterface $processor,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly Security $security,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
       assert($data instanceof User);

       /** @var User $currentUser */
       $currentUser = $this->security->getUser();

       if($data->getPlainPassword() && $data->getEmail() === $currentUser->getEmail()){
           $data->setPassword($this->userPasswordHasher->hashPassword($data, $data->getPlainPassword()));
       }

        $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
