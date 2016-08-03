<?php
// src/OC/CoreBundle/Repository/VersionRepository.php

namespace OC\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class VersionRepository extends EntityRepository
{
	public function getNewVersions($date) {
		return $this->createQueryBuilder('v')
			->where('v.date > :date')
			->setParameter(':date', $date)
      		->getQuery()
      		->getResult();
	}

}
