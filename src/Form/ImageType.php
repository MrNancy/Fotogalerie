<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ImageType extends AbstractType
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
            ->add('imageFile', VichFileType::class, [
                'required'       => false,
                'allow_delete'   => false,
                'download_label' => 'Herunterladen',
                'download_uri'   => true,
                'asset_helper'   => false,
                'attr' => [
                    'accept' => implode(', ', Image::ALLOWED_MIME_TYPES),
                ],
                'constraints'    => [
                    new File([
                        'maxSize'   => Image::MAX_IMAGE_SIZE,
                        'mimeTypes' => Image::ALLOWED_MIME_TYPES,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
