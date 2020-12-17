<?php

declare(strict_types=1);

namespace BitBag\SyliusCatalogPlugin\Repository;

use Sylius\Component\Resource\Repository\RepositoryInterface;

interface CatalogRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Catalog[]
     */
    public function findActive(\DateTimeImmutable $on): array;
}
