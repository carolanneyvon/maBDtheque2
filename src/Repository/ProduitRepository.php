<?php

namespace App\Repository;

use App\Classe\Search;
use App\Classe\SearchNav;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * requête qui permet de récuperer les produits en fonction da la recherche de l'utilisateur
     *
     * @return Produit[] 
     */
    public function findWithSearch(Search $search)
    {
        $query = $this->createQueryBuilder('p')
            ->select('c', 'p') // categorie et produit
            ->join('p.categorie', 'c'); // jointure entre la catégorie du produit et la table categorie

        if (!empty($search->categories)) {
            $query = $query->andWhere('c.id IN (:categories)')->setParameter('categories', $search->categories);
        }

        if (!empty($search->stringFilter)) {
            $query = $query->andWhere('p.titre LIKE :string OR p.auteur LIKE :string')->setParameter('string', "%$search->stringFilter%");

            // "% %"recherche partielle
        }

        return $query->getQuery()->getResult();
    }

    public function findWithSearchNav(SearchNav $search)
    {
        $query = $this->createQueryBuilder('p')
            ->select('c', 'p') // categorie et produit
            ->join('p.categorie', 'c'); // jointure entre la catégorie du produit et la table categorie

        if (!empty($search->categories)) {
            $query = $query->andWhere('c.id IN (:categories)')->setParameter('categories', $search->categories);
        }

        if (!empty($search->string)) {
            $query = $query->andWhere('p.titre LIKE :string OR p.auteur LIKE :string')->setParameter('string', "%$search->string%");

            // "% %"recherche partielle
        }

        return $query->getQuery()->getResult();
    }

    public const PAGINATOR_PER_PAGE = 9;        

    public function getAllProduitPaginator(int $offset): Paginator
        {
        $query = $this->createQueryBuilder('p')
            ->select('c', 'p') // categorie et produit
            ->join('p.categorie', 'c'); // jointure entre la catégorie du produit et la table categorie

        return new Paginator($query->setMaxResults(self::PAGINATOR_PER_PAGE)
                    ->setFirstResult($offset)
                    ->getQuery());
    }

    public function getProduitPaginator(int $offset, Search $search): Paginator
        {
        $query = $this->createQueryBuilder('p')
            ->select('c', 'p') // categorie et produit
            ->join('p.categorie', 'c'); // jointure entre la catégorie du produit et la table categorie

        if (!empty($search->categories)) {
            $query = $query->andWhere('c.id IN (:categories)')->setParameter('categories', $search->categories);
        }

        if (!empty($search->stringFilter)) {
            $query = $query->andWhere('p.titre LIKE :string OR p.auteur LIKE :string')->setParameter('string', "%$search->stringFilter%");

            // "% %"recherche partielle
        }

        return new Paginator($query->setMaxResults(self::PAGINATOR_PER_PAGE)
                    ->setFirstResult($offset)
                    ->getQuery());
    }



    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
