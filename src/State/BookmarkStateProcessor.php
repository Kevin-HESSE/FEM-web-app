<?php

namespace App\State;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\DeleteOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Entity\Video;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class BookmarkStateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: PersistProcessor::class )] private readonly ProcessorInterface $processor,
        private readonly Security $security
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {

        assert($data instanceof Video);

        /** @var User $user */
        $user = $this->security->getUser();

        if($operation instanceof DeleteOperationInterface){
            $data->removeUser($user);
        } else {
            $data->addUser($user);
        }

        $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
