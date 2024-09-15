<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageUploadController extends AbstractController
{
    #[Route('/upload', name: 'upload_image', methods: ['POST'])]
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
                    $this->getParameter('images_directory'),
                    $filename
                );

                $picture->setPath($filename);
                $entityManager->persist($picture);
                $entityManager->flush();

                return new Response('Image uploaded successfully', Response::HTTP_OK);
            }
        }

        return $this->render('upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}