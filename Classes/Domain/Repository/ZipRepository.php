<?php
namespace Creationx\CixContactperson\Domain\Repository;

use \TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

class ZipRepository extends Repository {

    public $table = 'tx_cix_contactperson_zip';

    /**
     * @param string $sZip
     * @return mixed
     */
    public function findByZip(string $sZip)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->table);
        return $queryBuilder
            ->select('zip', 'city', 'lat', 'lng')
            ->from($this->table)
            ->where($queryBuilder->expr()->like('zip', $sZip))
            ->execute()
            ->fetch();
    }
}
