<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusCatalogPlugin\Resolver;

use BitBag\SyliusCatalogPlugin\Checker\Rule\Doctrine\RuleInterface;
use BitBag\SyliusCatalogPlugin\Entity\AbstractCatalogRule;
use BitBag\SyliusCatalogPlugin\Entity\CatalogInterface;
use Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductRepository;
use Sylius\Component\Registry\ServiceRegistry;

class ProductsInsideCatalogResolver implements ProductsInsideCatalogResolverInterface
{
    /** @var ProductRepository */
    private $productRepository;

    /** @var ServiceRegistry */
    private $serviceRegistry;

    public function __construct(ProductRepository $productRepository, ServiceRegistry $serviceRegistry)
    {
        $this->serviceRegistry = $serviceRegistry;
        $this->productRepository = $productRepository;
    }

    public function findMatchingProducts(CatalogInterface $catalog): array
    {
        $connectingRules = $catalog->getConnectingRules();

        /** @var AbstractCatalogRule $rules */
        $rules = $catalog->getRules();

        $qb = $this->productRepository->createQueryBuilder('p')
            ->addSelect('min(price) AS HIDDEN min_price')
            ->addSelect('max(price) AS HIDDEN max_price')
            ->addGroupBy('p, name, variant, productTaxon, taxon')
            ->leftJoin('p.translations', 'name')
            ->leftJoin('p.variants', 'variant')
            ->leftJoin('p.productTaxons', 'productTaxon')
            ->leftJoin('productTaxon.taxon', 'taxon')
            ->leftJoin('variant.channelPricings', 'price');

        foreach ($rules as $rule) {
            $type = $rule->getType();

            /** @var RuleInterface $ruleChecker */
            $ruleChecker = $this->serviceRegistry->get($type);

            $ruleConfiguration = $rule->getConfiguration();

            $ruleChecker->modifyQueryBuilder($ruleConfiguration, $qb, $connectingRules);
        }

        return $qb
            ->getQuery()->getResult();
    }
}
