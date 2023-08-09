<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $releaseAt = null;

    #[ORM\Column]
    private ?bool $isTrending = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'videos')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id' , nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(targetEntity: Rating::class, inversedBy: 'videos')]
    #[ORM\JoinColumn(name: 'rating_id', referencedColumnName: 'id', nullable: false)]
    private ?Rating $rating = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'bookmark')]
    #[ORM\JoinTable(name: 'user_video')]
    private Collection $users;

    public function __construct()
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

    public function isTrending(): ?bool
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

    public function isBookmarked(): bool
    {
        return !$this->users->isEmpty();
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
