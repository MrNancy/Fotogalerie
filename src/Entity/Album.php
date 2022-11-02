<?php

namespace App\Entity;

use App\Entity\Trait\CreatedTrait;
use App\Entity\Trait\IdTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    use IdTrait;
    use SlugTrait;
    use CreatedTrait;

    #[ORM\Column(length: 455, nullable: true)]
    private ?string $pin = null;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Image::class, orphanRemoval: true)]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getPin(): ?string
    {
        return $this->pin;
    }

    public function setPin(?string $pin): self
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAlbum($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAlbum() === $this) {
                $image->setAlbum(null);
            }
        }

        return $this;
    }
}
