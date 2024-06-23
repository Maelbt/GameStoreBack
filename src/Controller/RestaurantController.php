<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Security\Core\User\UserInterface;



#[Route('api/restaurant', name: 'app_api_restaurant_')]

class RestaurantController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager, 
        private RestaurantRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
        )
    {   
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]

 /** @OA\Put(
     *     path="/api/restaurant/{id}",
     *     summary="Modifier un restaurant par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du restaurant à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Nom du restaurant"),
     *             @OA\Property(property="description", type="string", example="Description du restaurant"),
     *             @OA\Property(property="amOpeningTime", type="array", @OA\Items(type="string", example="11h-15h")),
     *             @OA\Property(property="pmOpeningTime", type="array", @OA\Items(type="string", example="18h-22h")),
     *             @OA\Property(property="maxGuest", type="integer", example=40)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant modifié avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Nom du restaurant"),
     *             @OA\Property(property="description", type="string", example="Description du restaurant"),
     *             @OA\Property(property="amOpeningTime", type="string", example="11h-15h"),
     *             @OA\Property(property="pmOpeningTime", type="string", example="18h-22h"),
     *             @OA\Property(property="maxGuest", type="integer", example=40),
     *             @OA\Property(property="createdAt", type="string", format="date-time"),
     *             @OA\Property(property="updatedAt", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant non trouvé"
     *     )
     * )
     */

    public function edit(int $id, Request $request): JsonResponse
    {
        // ... Edite le restaurant et le sauvegarde en BDD 
        $restaurant = $this->repository->findOneBy(['id' => $id]);
        if ($restaurant) {
           $restaurant = $this->serializer->deserialize(
               $request->getContent(),
               Restaurant::class,
               'json',
               [AbstractNormalizer::OBJECT_TO_POPULATE => $restaurant]
               );
           $restaurant->setUpdatedAt(new DateTimeImmutable());

           $this->manager->flush();

           return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    
 /** @OA\Delete(
     *     path="/api/restaurant/{id}",
     *     summary="Supprime un restaurant par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du restaurant à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant supprimé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Nom du restaurant"),
     *             @OA\Property(property="description", type="string", example="Description du restaurant"),
     *             @OA\Property(property="createdAt", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant non trouvé"
     *     )
     * )
     */

    public function delete(int $id): JsonResponse
    {
        // ... Supprime le restaurant de la BDD
        $restaurant = $this->repository->findOneBy(['id' => $id]);
        if ($restaurant) {
            $this->manager->remove($restaurant);
            $this->manager->flush();
    
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]

 /** @OA\Get(
     *     path="/api/restaurant/{id}",
     *     summary="Afficher un restaurant par ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du restaurant à afficher",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant trouvé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Nom du restaurant"),
     *             @OA\Property(property="description", type="string", example="Description du restaurant"),
     *             @OA\Property(property="createdAt", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant non trouvé"
     *     )
     * )
     */

    public function show(int $id): JsonResponse
    {
        // ... Affiche le restaurant de la BDD
        $restaurant = $this->repository->findOneBy(['id' => $id]);

        if ($restaurant) {
            $responseData = $this->serializer->serialize($restaurant, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    } 

    #[Route(name: 'new', methods: 'POST')]

/** @OA\Post(
     *     path="/api/restaurant",
     *     summary="Créer un restaurant",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données du restaurant à créer",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Nom du restaurant"),
     *             @OA\Property(property="description", type="string", example="Description du restaurant"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Restaurant créé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Nom du restaurant"),
     *             @OA\Property(property="description", type="string", example="Description du restaurant"),
     *             @OA\Property(property="createdAt", type="string", format="date-time")
     *         )
     *     )
     * )
     */

    public function new(Request $request): JsonResponse
    {
        $restaurant = $this->serializer->deserialize($request->getContent(), Restaurant::class, 'json');
        $restaurant->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($restaurant);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($restaurant, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_restaurant_show',
            ['id' => $restaurant->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    }
}
