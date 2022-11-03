<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Video;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('album', EntityType::class, [
                'class'        => Album::class,
                'required'     => true,
                'choice_label' => function (Album $entity) {
                    return $entity->getName();
                },
            ])
            ->add('videoFile', VichFileType::class, [
                'required'       => false,
                'allow_delete'   => false,
                'download_label' => 'Herunterladen',
                'download_uri'   => true,
                'asset_helper'   => false,
                'attr' => [
                    'accept' => implode(', ', Video::ALLOWED_MIME_TYPES),
                ],
                'constraints'    => [
                    new File([
                        'maxSize'   => Video::MAX_VIDEO_SIZE,
                        'mimeTypes' => Video::ALLOWED_MIME_TYPES,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
