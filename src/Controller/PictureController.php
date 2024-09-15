<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    #[Route('/api/picture/{id}', name: 'get_picture', methods: ['GET'])]
    public function getPicture(int $id, PictureRepository $pictureRepository): JsonResponse
    {
        $picture = $pictureRepository->find($id);

        if (!$picture) {
            return new JsonResponse(['message' => 'Picture not found'], Response::HTTP_NOT_FOUND);
        }

        $pictureUrl = $this->generateUrl('get_image', ['filename' => $picture->getPath()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse([
            'id' => $picture->getId(),
            'title' => $picture->getTitle(),
            'path' => $pictureUrl,
            'createdAt' => $picture->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }

    #[Route('/images/{filename}', name: 'get_image', methods: ['GET'])]
    public function serveImage(string $filename): Response
    {
        $filePath = $this->getParameter('images_directory').'/'.$filename;

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('Image not found');
        }

        return new Response(file_get_contents($filePath), 200, [
            'Content-Type' => mime_content_type($filePath),
        ]);
    }
}