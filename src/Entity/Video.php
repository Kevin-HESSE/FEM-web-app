<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\VideoRepository;
use App\State\VideoStateProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['video:read', 'video:item:read']]
)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[ApiFilter(SearchFilter::class, strategy: 'ipartial')]
    #[Groups(['video:read'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['video:read'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['video:read'])]
    private ?\DateTimeImmutable $releaseAt = null;

    #[ORM\Column]
    #[Groups(['video:read'])]
    #[ApiFilter(BooleanFilter::class)]
    private ?bool $isTrending = null;

    #[Groups(['video:read'])]
    private bool $isBookmarked = false;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'videos')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id' , nullable: false)]
    #[Groups(['video:read'])]
    private ?Category $category = null;

    #[ORM\ManyToOne(targetEntity: Rating::class, inversedBy: 'videos')]
    #[ORM\JoinColumn(name: 'rating_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['video:read'])]
    private ?Rating $rating = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'bookmark')]
    #[ORM\JoinTable(name: 'user_video')]
    #[Groups(['video:read'])]
    private Collection $users;

    public function __construct(#[CurrentUser] ?User $user = null)
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getReleaseAt(): ?\DateTimeImmutable
    {
        return $this->releaseAt;
    }

    public function setReleaseAt(\DateTimeImmutable $releaseAt): static
    {
        $this->releaseAt = $releaseAt;

        return $this;
    }

    public function getIsTrending(): ?bool
    {
        return $this->isTrending;
    }

    public function setIsTrending(bool $isTrending): static
    {
        $this->isTrending = $isTrending;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getRating(): ?Rating
    {
        return $this->rating;
    }

    public function setRating(?Rating $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function getIsBookmarked(User $user): bool
    {
        if($this->users->contains($user)){
            $this->isBookmarked = true;
        }

        return $this->isBookmarked;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addBookmark($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeBookmark($this);
        }

        return $this;
    }
}
