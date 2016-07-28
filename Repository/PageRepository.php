<?php
// src/OC/CoreBundle/Repository/PageRepository.php

namespace OC\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PageRepository extends EntityRepository
{

  public function getPages()
  {
    $query = $this->createQueryBuilder('p')
      ->getQuery()
    ;


    // Enfin, on retourne l'objet Paginator correspondant à la requête construite
    // (n'oubliez pas le use correspondant en début de fichier)
    return $query
      ->getResult()
    ;
  }


  public function getPage($slug)
  {
    $qb = $this->createQueryBuilder('p');

    $qb
      ->where('p.slug = :slug')
      ->setParameter('slug', $slug)
    ;

    return $qb
      ->getQuery()
      ->getResult()
    ;
  }

}
