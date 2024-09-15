<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\ORM\EntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }
    
    public function findWithPicture($id)
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.picture', 'p')
            ->addSelect('p')
            ->where('g.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllbyId(): array
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }

    public function findAllbyPrice(): array
    {
        return $this->findBy(array(), array('price' => 'ASC'));
    }

    public function findAllbyGenre(): array
    {
        return $this->findBy(array(), array('genre' => 'ASC'));
    }

    public function findByCriteria(array $criteria): array
    {
        $qb = $this->createQueryBuilder('g');

        if (isset($criteria['genre'])) {
            $qb->andWhere('g.genre LIKE :genre')
               ->setParameter('genre', '%' . $criteria['genre'] . '%');
        }

        if (isset($criteria['price'])) {
            $priceRange = explode('-', $criteria['price']);
            if (count($priceRange) === 2) {
                $qb->andWhere('g.price BETWEEN :minPrice AND :maxPrice')
                   ->setParameter('minPrice', $priceRange[0])
                   ->setParameter('maxPrice', $priceRange[1]);
            }
        }

        return $qb->getQuery()->getResult();
    }
}
