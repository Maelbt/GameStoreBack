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
}
