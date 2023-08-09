<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Video;
use App\Model\VideoInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Video>
 *
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }


    /**
     * Retrieve all videos without or with bookmark for the current user
     * @uses getAllVideosInformationWithUserBookmark
     * @param User $user
     * @return Video[]
     */
    public function findAllVideoWithUserBookmarks(User $user): array
    {
        $queryBuilder = $this->getAllVideosInformationWithUserBookmark($user);

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve all videos by category without or with bookmark for the current user
     * @uses getAllVideosInformationWithUserBookmark
     * @param User $user
     * @param Category $category
     * @return array
     */
    public function findAllVideosWithUserBookmarksByCategory(User $user, Category $category): array
    {
        $queryBuilder = $this->getAllVideosInformationWithUserBookmark($user);

        return $queryBuilder
            ->andWhere('category.id = :categoryId')
            ->setParameter('categoryId', $category->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve all bookmarked videos for the current user
     * @uses addBasicsVideoInformation
     * @param User $user
     * @return array
     */
    public function findAllBookmarkedVideoForUser(User $user): array
    {
        return $this->addBasicsVideoInformation()
            ->leftJoin('video.users', 'users')
            ->where('users.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve all videos when the user search with a specified term
     * @uses getAllVideosInformationWithUserBookmark
     * @uses addTermCorrespondence
     * @param string $term
     * @param User $user
     * @return array
     */
    public function findTitleByTerm(string $term, User $user): array
    {
        $queryBuilder = $this->getAllVideosInformationWithUserBookmark($user);

        $queryBuilder = $this->addTermCorrespondence($term, $queryBuilder);

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve all videos for a category when the user search with a specified term
     * @uses addBasicsVideoInformation
     * @uses addTermCorrespondence
     * @param string $term
     * @param Category $category
     * @return array
     */
    public function findTitleByTermAndCategory(string $term, Category $category): array
    {
        $queryBuilder = $this->addBasicsVideoInformation();

        $queryBuilder
            ->where('video.category = :category')
            ->setParameter('category', $category->getId());

        $queryBuilder = $this->addTermCorrespondence($term, $queryBuilder);

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve all bookmark videos when the user search with a specified term
     * @uses addBasicsVideoInformation
     * @uses addTermCorrespondence
     * @param string $term
     * @param User $user
     * @return array
     */
    public function findBookmarkTitleByTerm(string $term, User $user): array
    {
        $queryBuilder = $this->addBasicsVideoInformation();

        $queryBuilder = $queryBuilder
            ->leftJoin('video.users', 'users')
            ->where('users.id = :userId')
            ->setParameter('userId', $user->getId());

        $queryBuilder = $this->addTermCorrespondence($term, $queryBuilder);

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * Allow to filter the query result based on a string
     * It is use mainly for all query with the search bar
     * @param string $term
     * @param QueryBuilder $queryBuilder
     * @return QueryBuilder
     */
    private function addTermCorrespondence(string $term, QueryBuilder $queryBuilder): QueryBuilder
    {
        return $queryBuilder
            ->andWhere('LOWER(video.title) LIKE LOWER(:like)')
            ->setParameter('like', '%'.$term.'%');
    }

    /**
     * Construct a query with all information and bookmark relation with a specified user
     * @uses addBookmarkInformationByUser
     * @uses addBasicsVideoInformation
     * @param User $user
     * @return QueryBuilder
     */
    private function getAllVideosInformationWithUserBookmark(User $user): QueryBuilder
    {
        $queryBuilder = $this->addBasicsVideoInformation();

        return $this->addBookmarkInformationByUser($user, $queryBuilder);
    }

    /**
     * Add information about the relation between User and Video based on the specified User
     * The query builder must be initialised before.
     * @param User $user
     * @param QueryBuilder $queryBuilder
     * @return QueryBuilder
     */
    private function addBookmarkInformationByUser(User $user, QueryBuilder $queryBuilder): QueryBuilder
    {
        return $queryBuilder
            ->addSelect('users')
            ->leftJoin('video.users', 'users', 'with', 'users.id = :userId')
            ->setParameter('userId', $user->getId())
            ->orderBy('video.id');
    }

    /**
     * Construct or add information to the query builder.
     * Use it whenever you need to inject rating and category information to the query
     * @param QueryBuilder|null $queryBuilder
     * @return QueryBuilder
     */
    private function addBasicsVideoInformation(?QueryBuilder $queryBuilder = null): QueryBuilder
    {
        $queryBuilder = $queryBuilder ?? $this->createQueryBuilder('video')->select('video');

        return $queryBuilder
            ->addSelect('rating')
            ->addSelect('category')
            ->join('video.rating', 'rating')
            ->join('video.category', 'category');
    }
}
