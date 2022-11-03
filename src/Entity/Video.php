<?php

namespace App\Entity;

use App\Entity\Trait\CreatedTrait;
use App\Entity\Trait\IdTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    public const ALLOWED_MIME_TYPES = ['video/mp4', 'video/m3u8', 'video/mov', 'video/avi', 'video/webm', 'video/ogg', 'application/octet-stream'];
    public const MAX_VIDEO_SIZE = '10240k';
    use IdTrait;
    use SlugTrait;
    use CreatedTrait;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Album $album = null;
    #[ORM\Column(length: 255, nullable: false)]
    private ?string $video = '';
    #[Vich\UploadableField(mapping: 'videos', fileNameProperty: 'video')]
    #[File(maxSize: self::MAX_VIDEO_SIZE, mimeTypes: self::ALLOWED_MIME_TYPES)]
    private $videoFile = null;

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function setVideoFile($video): self
    {
        $this->videoFile = $video;

        $this->updated = new \DateTime('now');

        return $this;
    }

    public function getVideoFile()
    {
        return $this->videoFile;
    }

    public function setVideo($video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getVideo(): string
    {
        return $this->video;
    }
}
