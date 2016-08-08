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
      ->leftJoin('p.category', 'c')
      ->addSelect('c')
      ->getQuery()
    ;


    // Enfin, on retourne l'objet Paginator correspondant à la requête construite
    // (n'oubliez pas le use correspondant en début de fichier)
    return $query
      ->getResult()
    ;
  }


}
