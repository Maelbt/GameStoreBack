<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('api/game', name: 'app_api_game_')]

class GameController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private GameRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
        )
    {
    }

    #[OA\Put(
        path: '/api/game/{id}',
        summary: 'Modifier un jeu par ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID du jeu à modifier',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Nouvelles données du jeu à mettre à jour',
            content: new OA\JsonContent(
                type: 'object',
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Nouveau nom du jeu'),
                    new OA\Property(property: 'description', type: 'string', example: 'Nouvelle description du jeu'),
                    new OA\Property(property: 'pegi', type: 'integer', example: 16),
                    new OA\Property(property: 'genre', type: 'array', items: new OA\Items(type: 'string', example: 'RPG')),
                    new OA\Property(property: 'plateforme', type: 'array', items: new OA\Items(type: 'string', example: 'Playstation')),
                    new OA\Property(property: 'price', type: 'float', example: 69.99),
                    new OA\Property(property: 'promotion', type: 'integer', example: 20),
                    new OA\Property(property: 'quantity', type: 'integer', example: 100),
                    new OA\Property(property: 'releaseDate', type: 'string', example: '06/04/1999')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 204,
                description: 'Jeu modifié avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Jeu non trouvé'
            )
        ]
    )]

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        // ... Edite le jeu et le sauvegarde en BDD
        $game = $this->repository->findOneBy(['id' => $id]);
        if ($game) {
           $game = $this->serializer->deserialize(
               $request->getContent(),
               Game::class,
               'json',
               [AbstractNormalizer::OBJECT_TO_POPULATE => $game]
               );
           $game->setUpdatedAt(new DateTimeImmutable());

           $this->manager->flush();

           return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[OA\Delete(
        path: '/api/game/{id}',
        summary: 'Supprimer un jeu par ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID du jeu à supprimer',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Jeu supprimé avec succès'
            ),
            new OA\Response(
                response: 404,
                description: 'Jeu non trouvé'
            )
        ]
    )]

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        // ... Supprime le jeu de la BDD
        $game = $this->repository->findOneBy(['id' => $id]);
        if ($game) {
            $this->manager->remove($game);
            $this->manager->flush();
    
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[OA\Get(
        path: '/api/game/{id}',
        summary: 'Afficher un jeu par ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID du jeu à afficher',
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Jeu trouvé avec succès',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Nom du jeu'),
                        new OA\Property(property: 'description', type: 'string', example: 'Description du jeu'),
                        new OA\Property(property: 'pegi', type: 'integer', example: 16),
                        new OA\Property(property: 'genre', type: 'array', items: new OA\Items(type: 'string', example: 'RPG')),
                        new OA\Property(property: 'plateforme', type: 'array', items: new OA\Items(type: 'string', example: 'Playstation')),
                        new OA\Property(property: 'price', type: 'float', example: 69.99),
                        new OA\Property(property: 'promotion', type: 'integer', example: 20),
                        new OA\Property(property: 'quantity', type: 'integer', example: 100),
                        new OA\Property(property: 'releaseDate', type: 'string', example: '06/04/1999'),
                        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time')
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Jeu non trouvé'
            )
        ]
    )]

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        // ... Affiche le jeu de la BDD
        $game = $this->repository->findOneBy(['id' => $id]);

        if ($game) {
            $responseData = $this->serializer->serialize($game, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    /*public function show($id, GameRepository $gameRepository): JsonResponse
    {
        $game = $gameRepository->findWithPicture($id);

        if (!$game) {
            return new JsonResponse(['message' => 'Game not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $game->getId(),
            'name' => $game->getName(),
            'description' => $game->getDescription(),
            'pegi' => $game->getPegi(),
            'genre' => $game->getGenre(),
            'plateforme' => $game->getPlateforme(),
            'price' => $game->getPrice(),
            'promotion' => $game->getPromotion(),
            'quantity' => $game->getQuantity(),
            'releaseDate' => $game->getReleaseDate(),
            'picture' => $game->getPicture()->getPath(), // Assurez-vous que cela retourne l'URL ou le chemin correct
        ];

        return new JsonResponse($data);
    }*/

    #[Route(methods: 'POST')]
    #[OA\Post(
        path: '/api/game',
        summary: 'Créer un jeu',
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Données du jeu à créer',
            content: new OA\JsonContent(
                type: 'object',
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Nom du jeu'),
                    new OA\Property(property: 'description', type: 'string', example: 'Description du jeu'),
                    new OA\Property(property: 'pegi', type: 'integer', example: 16),
                    new OA\Property(property: 'genre', type: 'array', items: new OA\Items(type: 'string', example: 'RPG')),
                    new OA\Property(property: 'plateforme', type: 'array', items: new OA\Items(type: 'string', example: 'Playstation')),
                    new OA\Property(property: 'price', type: 'float', example: 69.99),
                    new OA\Property(property: 'promotion', type: 'integer', example: 20),
                    new OA\Property(property: 'quantity', type: 'integer', example: 100),
                    new OA\Property(property: 'releaseDate', type: 'string', example: '06/04/1999')
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Jeu créé avec succès',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Nom du jeu'),
                        new OA\Property(property: 'description', type: 'string', example: 'Description du jeu'),
                        new OA\Property(property: 'pegi', type: 'integer', example: 16),
                        new OA\Property(property: 'genre', type: 'array', items: new OA\Items(type: 'string', example: 'RPG')),
                        new OA\Property(property: 'plateforme', type: 'array', items: new OA\Items(type: 'string', example: 'Playstation')),
                        new OA\Property(property: 'price', type: 'float', example: 69.99),
                        new OA\Property(property: 'promotion', type: 'integer', example: 20),
                        new OA\Property(property: 'quantity', type: 'integer', example: 100),
                        new OA\Property(property: 'releaseDate', type: 'string', example: '06/04/1999'),
                        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time')
                    ]
                )
            )
        ]
    )]

    public function new(Request $request): JsonResponse
    {
        $game = $this->serializer->deserialize($request->getContent(), Game::class, 'json');
        $game->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($game);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($game, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_game_show',
            ['id' => $game->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route(methods: 'GET')]
    #[OA\Get(
        path: '/api/game',
        summary: 'Afficher tous les jeux de la BDD',
        parameters: [],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Jeux trouvé avec succès',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'name', type: 'string', example: 'Nom du jeu'),
                        new OA\Property(property: 'description', type: 'string', example: 'Description du jeu'),
                        new OA\Property(property: 'pegi', type: 'integer', example: 16),
                        new OA\Property(property: 'genre', type: 'array', items: new OA\Items(type: 'string', example: 'RPG')),
                        new OA\Property(property: 'plateforme', type: 'array', items: new OA\Items(type: 'string', example: 'Playstation')),
                        new OA\Property(property: 'price', type: 'float', example: 69.99),
                        new OA\Property(property: 'promotion', type: 'integer', example: 20),
                        new OA\Property(property: 'quantity', type: 'integer', example: 100),
                        new OA\Property(property: 'releaseDate', type: 'string', example: '06/04/1999'),
                        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time')
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Jeux non trouvé'
            )
        ]
    )]

    public function allgames(): JsonResponse
    {
        // ... Affiche tous les jeux de la BDD
        $find_all = $this->repository->findAll();
        $games = [];
        foreach($find_all as $game)
        {
            $games[] = [
                'id' => $game->getId(),
                'name' => $game->getName(),
                'description' => $game->getDescription(),
                'pegi' => $game->getPegi(),
                'genre' => $game->getGenre(),
                'plateforme' => $game->getPlateforme(),
                'price' => $game->getPrice(),
                'promotion' => $game->getPromotion(),
                'quantity' => $game->getQuantity(),
                'releaseDate' => $game->getReleaseDate()
            ];
        }
        if(count($games)>=0)
        {
        $responseData = $this->serializer->serialize($games, 'json');
        return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
