<?php

namespace spec\BitBag\SyliusCatalogPlugin\Resolver;

use BitBag\SyliusCatalogPlugin\Entity\CatalogInterface;
use BitBag\SyliusCatalogPlugin\Resolver\CatalogsForProductResolverInterface;
use BitBag\SyliusCatalogPlugin\Resolver\CompleteCatalogsForProductResolver;
use BitBag\SyliusCatalogPlugin\Resolver\ProductsInsideCatalogResolverInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductInterface;

class CompleteCatalogsForProductResolverSpec extends ObjectBehavior
{
    function let(
        CatalogsForProductResolverInterface $catalogsForProductResolver,
        ProductsInsideCatalogResolverInterface $catalogResolver
    ): void {
        $this->beConstructedWith($catalogsForProductResolver, $catalogResolver);
    }

    function it_resolves_products_inside_each_catalog(
        ProductInterface $product,
        CatalogInterface $catalog1,
        CatalogInterface $catalog2,
        ProductInterface $productInsideCatalog1,
        ProductInterface $productInsideCatalog2,
        CatalogsForProductResolverInterface $catalogsForProductResolver,
        ProductsInsideCatalogResolverInterface $catalogResolver
    ): void {
        $date = new \DateTimeImmutable();
        $catalogsForProductResolver->resolveProductCatalogs($product, $date)->willReturn([$catalog1, $catalog2]);
        $catalogResolver->findMatchingProducts($catalog1)->willReturn([$productInsideCatalog1]);
        $catalogResolver->findMatchingProducts($catalog2)->willReturn([$productInsideCatalog2]);

        $this->resolveProductCatalogs($product, $date)->shouldIterateAs(
            [
                [
                    'catalog' => $catalog1,
                    'products' => [$productInsideCatalog1],
                ],
                [
                    'catalog' => $catalog2,
                    'products' => [$productInsideCatalog2],
                ],
            ]
        );
    }

    function it_filters_out_empty_catalogs(
        ProductInterface $product,
        CatalogInterface $catalogNotEmpty,
        CatalogInterface $catalogEmpty,
        ProductInterface $productInsideCatalog,
        CatalogsForProductResolverInterface $catalogsForProductResolver,
        ProductsInsideCatalogResolverInterface $catalogResolver
    ): void {
        $date = new \DateTimeImmutable();
        $catalogsForProductResolver->resolveProductCatalogs($product, $date)->willReturn([$catalogEmpty, $catalogNotEmpty]);
        $catalogResolver->findMatchingProducts($catalogEmpty)->willReturn([]);
        $catalogResolver->findMatchingProducts($catalogNotEmpty)->willReturn([$productInsideCatalog]);

        $this->resolveProductCatalogs($product, $date)->shouldIterateAs(
            [
                [
                    'catalog' => $catalogNotEmpty,
                    'products' => [$productInsideCatalog],
                ],
            ]
        );
    }
}
