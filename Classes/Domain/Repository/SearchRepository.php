<?php
namespace Creationx\CixContactperson\Domain\Repository;

use \TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

class SearchRepository extends Repository {
    public function findByRadius(float $lat, float $lng, int $radius) {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('tt_address');
        return $queryBuilder->selectLiteral(
            '*',
            '(ACOS(
                SIN(RADIANS(tt_address.latitude)) * SIN(RADIANS(' . $lat . '))
                + COS(RADIANS(tt_address.latitude)) * COS(RADIANS(' . $lat . '))
                * COS(RADIANS(tt_address.longitude) - RADIANS(' . $lng . ')
            )) * 6380) AS distance'
        )
        ->from('tt_address')
        ->having($queryBuilder->expr()->lte('distance', $queryBuilder->createNamedParameter($radius, \PDO::PARAM_INT)))
        ->orderBy('distance', 'ASC')
        ->execute()
        ->fetchAll();
    }

    public function findByCategory($sKeyword)
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('sys_category');

        return $queryBuilder
            ->select('uid', 'cix_zips', 'cix_keywords')
            ->from('sys_category')
            ->where(
                $queryBuilder->expr()->like(
                    'cix_zips',
                    $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($sKeyword) . '%')
                )
            )->OrWhere(
                $queryBuilder->expr()->like(
                    'cix_keywords',
                    $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($sKeyword) . '%')
                )
            )->execute()
            ->fetchAll();
    }


    public function findByUid($uid)
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('sys_category');

        return $queryBuilder
            ->select('uid', 'cix_zips', 'cix_keywords')
            ->from('sys_category')
            ->where(
                $queryBuilder->expr()->eq(
                    'uid',
                    $queryBuilder->createNamedParameter($uid)
                )
            )->execute()
            ->fetchAll();
    }

    public function findByCategoryRelation($categories)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('sys_category_record_mm');

        return $queryBuilder
            ->select('uid_foreign')
            ->from('sys_category_record_mm')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->in('uid_local', $categories),
                    $queryBuilder->expr()->eq('tablenames', '\'tt_address\''),
                    $queryBuilder->expr()->eq('fieldname', '\'categories\'')
                )
            )
            ->execute()
            ->fetchAll();
    }
}
