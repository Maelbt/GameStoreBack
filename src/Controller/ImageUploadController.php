<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ImageUploadController extends AbstractController
{
    #[Route('/upload', name: 'upload_image')]
    public function upload(Request $request, EntityManagerInterface $entityManager): Response
    {
        $picture = new Picture();
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            if ($file) {
                $filename = uniqid().'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('images_directory'), // Paramètre défini dans config/services.yaml
                    $filename
                );

                $picture->setPath($filename);
                $entityManager->persist($picture);
                $entityManager->flush();

                return $this->redirectToRoute('success_page'); // Redirection après upload
            }
        }

        return $this->render('upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}