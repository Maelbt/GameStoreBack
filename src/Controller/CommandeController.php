<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('api/commande', name: 'app_api_commande_')]

class CommandeController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private CommandeRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
        )
    {
    }

    #[OA\Get(
        path: '/api/commande/{id}',
        summary: 'Afficher une commande par ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID de la commande à afficher',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Commande trouvée avec succès',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'statut', type: 'string', example: 'VALIDE'),
                        new OA\Property(property: 'prixTotal', type: 'float', example: 69.99),
                        new OA\Property(property: 'dateCommande', type: 'string', format: 'date-time'),
                        new OA\Property(property: 'agence', type: 'string', example: 'Bordeaux'),
                        new OA\Property(property: 'dateRetrait', type: 'string', example: '27/04/2024'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Commande non trouvée'
            )
        ]
    )]

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        // ... Affiche le jeu de la BDD
        $commande = $this->repository->findOneBy(['id' => $id]);

        if ($commande) {
            $responseData = $this->serializer->serialize($commande, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }



    #[Route(methods: 'POST')]
    #[OA\Post(
        path: '/api/commande',
        summary: 'Créer une commande',
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Données de la commande à créer',
            content: new OA\JsonContent(
                type: 'object',
                properties: [
                    new OA\Property(property: 'statut', type: 'string', example: 'VALIDE'),
                    new OA\Property(property: 'prixTotal', type: 'float', example: 69.99),
                    new OA\Property(property: 'dateCommande', type: 'string', format: 'date-time'),
                    new OA\Property(property: 'agence', type: 'string', example: 'Bordeaux'),
                    new OA\Property(property: 'dateRetrait', type: 'string', example: '27/04/2024'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Commande créée avec succès',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'statut', type: 'string', example: 'VALIDE'),
                        new OA\Property(property: 'prixTotal', type: 'float', example: 69.99),
                        new OA\Property(property: 'dateCommande', type: 'string', format: 'date-time'),
                        new OA\Property(property: 'agence', type: 'string', example: 'Bordeaux'),
                        new OA\Property(property: 'dateRetrait', type: 'string', example: '27/04/2024'),
                    ]
                )
            )
        ]
    )]

    public function new(Request $request): JsonResponse
    {
        $commande = $this->serializer->deserialize($request->getContent(), Commande::class, 'json');

        $this->manager->persist($commande);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($commande, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_commande_show',
            ['id' => $commande->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }




    #[OA\Put(
        path: '/api/commande/{id}',
        summary: 'Modifier le statut d\'une commande par ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID de la commande à modifier',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Nouvelles données de la commande à mettre à jour',
            content: new OA\JsonContent(
                type: 'object',
                properties: [
                    new OA\Property(property: 'statut', type: 'string', example: 'LIVRE'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 204,
                description: 'Commande modifiée avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Commande non trouvée'
            )
        ]
    )]

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $commande = $this->repository->findOneBy(['id' => $id]);
        if ($commande) {
           $commande = $this->serializer->deserialize(
               $request->getContent(),
               Commande::class,
               'json',
               [AbstractNormalizer::OBJECT_TO_POPULATE => $commande]
               );

           $this->manager->flush();

           return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

}
