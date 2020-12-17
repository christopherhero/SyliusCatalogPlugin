<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusCatalogPlugin\Twig\Extension;

use BitBag\SyliusCatalogPlugin\Entity\CatalogInterface;
use BitBag\SyliusCatalogPlugin\Resolver\ProductCatalogResolverInterface;
use BitBag\SyliusCatalogPlugin\Resolver\ProductResolverInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\Templating\EngineInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderProductCatalogsExtension extends AbstractExtension
{
    /** @var EngineInterface */
    private $engine;

    /** @var ProductCatalogResolverInterface */
    private $productCatalogResolver;

    /** @var ProductResolverInterface */
    private $productResolver;

    public function __construct(
        EngineInterface $engine,
        ProductCatalogResolverInterface $productCatalogResolver,
        ProductResolverInterface $productResolver
        ) {
        $this->engine = $engine;
        $this->productCatalogResolver = $productCatalogResolver;
        $this->productResolver = $productResolver;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('bitbag_render_product_catalogs', [$this, 'renderProductCatalogs'], ['is_safe' => ['html']]),
        ];
    }

    public function renderProductCatalogs(ProductInterface $product, ?string $date = null, ?string $template = null): string
    {
        $catalogs = $this->productCatalogResolver->resolveProductCatalogs($product, new \DateTimeImmutable($date ?? 'now'));

        $template = $template ?? '@BitBagSyliusCatalogPlugin/Product/showCatalogs.html.twig';

        $catalogs = array_map(
            function (CatalogInterface $catalog) {
                return [
                    'catalog' => $catalog,
                    'products' => $this->productResolver->findMatchingProducts($catalog),
                ];
            },
            $catalogs
        );

        return $this->engine->render($template, ['catalogs' => $catalogs]);
    }
}
