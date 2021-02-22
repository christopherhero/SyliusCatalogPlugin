<?php

declare(strict_types=1);

namespace BitBag\SyliusCatalogPlugin\Resolver;

use BitBag\SyliusCatalogPlugin\Entity\CatalogInterface;
use Sylius\Component\Core\Model\ProductInterface;

interface CatalogsForProductResolverInterface
{
    /** @return CatalogInterface[] */
    public function resolveProductCatalogs(ProductInterface $product, \DateTimeImmutable $dataTime): array;
}
