<?php

declare(strict_types=1);

namespace BitBag\SyliusCatalogPlugin\QueryBuilder;

use Doctrine\Common\Collections\Collection;

interface ProductQueryBuilderInterface
{
    public function findMatchingProductsQuery(string $connectingRules, Collection $rules);
}
