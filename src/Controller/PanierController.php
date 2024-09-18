<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Game;
use App\Entity\User;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private PanierRepository $repository;

    public function __construct(PanierRepository $repository)
    {
        $this->repository = $repository;
    }


    #[Route('/ajouter-au-panier/{gameId}', name: 'ajouter_au_panier')]
    public function ajouterAuPanier(int $gameId, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('signin');
        }

        // Récupérer le jeu par ID
        $game = $entityManager->getRepository(Game::class)->find($gameId);
        if (!$game) {
            throw $this->createNotFoundException('Le jeu n\'existe pas.');
        }

        // Récupérer ou créer le panier de l'utilisateur
        $panier = $user->getPanier();
        if (!$panier) {
            $panier = new Panier();
            $panier->setUser($user);
            $entityManager->persist($panier);
        }

        // Ajouter le jeu au panier
        $panier->addGame($game);

        $entityManager->persist($panier);
        $entityManager->flush();

        return $this->redirectToRoute('panier');
    }

    #[OA\Get(
        path: '/api/panier',
        summary: 'Afficher le panier de l\'utilisateur connecté',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Panier trouvé avec succès',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'games', type: 'array',
                            items: new OA\Schema(ref: "#/components/schemas/Game")
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Panier non trouvé'
            )
        ]
    )]

    #[Route('/api/panier', name: 'show_user_cart', methods: 'GET')]
    public function showUserCart(): JsonResponse
    {
        // Vérifier si l'utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['message' => 'User not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Récupérer le panier de l'utilisateur
        $panier = $user->getPanier();

        if (!$panier) {
            return new JsonResponse(['message' => 'Cart not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Récupérer les jeux dans le panier
        $games = $panier->getGame()->map(function ($game) {
            return [
                'id' => $game->getId(),
                'name' => $game->getName(),
                'price' => $game->getPrice(),
                'promotion' => $game->getPromotion(),
            ];
        })->toArray();

        // Construire la réponse
        $data = [
            'id' => $panier->getId(),
            'games' => $games,
        ];

        return new JsonResponse($data);
    }
}



