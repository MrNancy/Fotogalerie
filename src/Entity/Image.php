<?php

namespace App\Entity;

use App\Entity\Trait\CreatedTrait;
use App\Entity\Trait\IdTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    use IdTrait;
    use SlugTrait;
    use CreatedTrait;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $image = '';

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'image')]
    private $imageFile = null;

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function setImageFile($image): self
    {
        $this->imageFile = $image;

        $this->updated = new \DateTime('now');

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}
