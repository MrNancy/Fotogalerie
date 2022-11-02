<?php

namespace App\Controller;

use App\Entity\Album;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    private AlbumRepository $albumRepository;

    public function __construct(AlbumRepository $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    #[Route('/gallery/{_albumSlug}/', name: 'app_gallery')]
    public function withoutPin(Request $request): Response
    {
        $albumSlug = $request->get('_albumSlug');
        $album = $this->albumRepository->findOneBy(['slug' => $albumSlug]);

        if (!$album instanceof Album) {
            return $this->redirectToRoute('app_index');
        }

        if (trim($album->getPin()) !== '') {
            $form = $this->createFormBuilder()
                ->add('pin', PasswordType::class)
                ->add('submit', SubmitType::class)
                ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if (trim($album->getPin() !== $form->get('pin')->getData())) {
                    $this->addFlash('error', 'Das ist nicht das richtige Passwort.');

                    return $this->redirectToRoute('app_gallery', ['_albumSlug' => $albumSlug]);
                }

                return $this->redirectToRoute('app_gallery_pin', [
                    '_albumSlug' => $albumSlug,
                    '_pinSlug' => $album->getPin()
                ]);
            }

            return $this->render('gallery/pin.html.twig', [
                'album' => $album,
                'form' => $form->createView()
            ]);
        }

        return $this->render('gallery/index.html.twig', [
            'album' => $album
        ]);
    }

    #[Route('/gallery/{_albumSlug}/{_pinSlug}/', name: 'app_gallery_pin')]
    public function withPin(Request $request): Response
    {
        $albumSlug = $request->get('_albumSlug');
        $pinSlug = $request->get('_pinSlug');
        $album = $this->albumRepository->findOneBy(['slug' => $albumSlug, 'pin' => $pinSlug]);

        if (!$album instanceof Album) {
            return $this->redirectToRoute('app_index');
        }

        return $this->render('gallery/index.html.twig', [
            'album' => $album
        ]);
    }
}
