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
use BitBag\SyliusCatalogPlugin\Resolver\CatalogsForProductResolverInterface;
use BitBag\SyliusCatalogPlugin\Resolver\ProductsInsideCatalogResolverInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\Templating\EngineInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class RenderProductCatalogsExtension extends AbstractExtension
{
    /** @var EngineInterface */
    private $engine;

    /** @var CatalogsForProductResolverInterface */
    private $productCatalogResolver;

    /** @var ProductsInsideCatalogResolverInterface */
    private $productResolver;

    public function __construct(
        EngineInterface $engine,
        CatalogsForProductResolverInterface $productCatalogResolver
        ) {
        $this->engine = $engine;
        $this->productCatalogResolver = $productCatalogResolver;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('bitbag_render_product_catalogs', [$this, 'renderProductCatalogs'], ['is_safe' => ['html']]),
        ];
    }

    public function renderProductCatalogs(ProductInterface $product, ?string $date = null, ?string $template = null): string
    {
<<<<<<< Updated upstream
        $catalogs = $this->productCatalogResolver->resolveProductCatalogs($product, new \DateTimeImmutable($date ?? 'now'));

        $template = $template ?? '@BitBagSyliusCatalogPlugin/Product/showCatalogs.html.twig';

        $catalogs =
            array_filter(
                array_map(
                    function (CatalogInterface $catalog) {
                        return [
                            'catalog' => $catalog,
                            'products' => $this->productResolver->findMatchingProducts($catalog),
                        ];
                    },
                    $catalogs
                ),
                function (array $catalogData) {
                    return 0 < count($catalogData['products']);
                }
            )
         ;

        return $this->engine->render($template, ['catalogs' => $catalogs]);
=======
        return $this->engine->render(
            $template ?? '@BitBagSyliusCatalogPlugin/Product/showCatalogs.html.twig',
            [
                'catalogs' => $this->productCatalogResolver->resolveProductCatalogs(
                    $product,
                    new \DateTimeImmutable($date ?? 'now')
                )
            ]
        );
>>>>>>> Stashed changes
    }
}
