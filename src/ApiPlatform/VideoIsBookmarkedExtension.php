<?php

namespace App\ApiPlatform;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

class VideoIsBookmarkedExtension implements QueryCollectionExtensionInterface
{
    public function __construct(private readonly Security $security)
    {
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if(Video::class !== $resourceClass){
            return;
        }

        $rootAliases = $queryBuilder->getRootAliases()[0];
        /** @var User $user */
        $user = $this->security->getUser();

        $queryBuilder->addSelect('users')
            ->leftJoin(sprintf('%s.users', $rootAliases), 'users', 'with', 'users.id = :userId')
            ->setParameter('userId', $user->getId());
    }

}