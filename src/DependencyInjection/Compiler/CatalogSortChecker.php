<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusCatalogPlugin\DependencyInjection\Compiler;

use BitBag\SyliusCatalogPlugin\Checker\Sort\Doctrine\SortInterface as DoctrineSortInterface;
use BitBag\SyliusCatalogPlugin\Checker\Sort\Elasticsearch\SortInterface as ElasticsearchSortInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CatalogSortChecker implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $drivers = [
            'doctrine' => DoctrineSortInterface::class,
            'elasticsearch' => ElasticsearchSortInterface::class,
        ];

        foreach ($drivers as $driver => $sortInterface) {
            $this->addDriverSortsToRegistries($driver, $container, $sortInterface);
        }
    }

    private function serviceImplementsInterface(ContainerBuilder $container, string $id, string $sortInterface): bool
    {
        return isset(class_implements($container->getDefinition($id)->getClass())[$sortInterface]);
    }

    private function addDriverSortsToRegistries(string $driver, ContainerBuilder $container, string $sortInterface): void
    {
        $driverSortRegistry = sprintf('bitbag_sylius_catalog_plugin.registry_catalog_sort_checker.%s', $driver);

        if (!$container->has($driverSortRegistry)) {
            return;
        }

        $catalogSortCheckerRegistry = $container->getDefinition($driverSortRegistry);

        $catalogSortCheckerTypeToLabelMap = [];

        foreach ($container->findTaggedServiceIds('bitbag_sylius_catalog_plugin.catalog_sort_checker') as $id => $attributes) {
            if ($this->serviceImplementsInterface($container, $id, $sortInterface)) {
                foreach ($attributes as $attribute) {
                    if (!isset($attribute['type'], $attribute['label'])) {
                        throw new \InvalidArgumentException('Tagged sort checker `' . $id . '`needs to have `type` and `label` attributes');
                    }

                    $catalogSortCheckerTypeToLabelMap[$attribute['type']] = $attribute['label'];
                    $catalogSortCheckerRegistry->addMethodCall('register', [$attribute['type'], new Reference($id)]);
                }
            }
        }

        $container->setParameter(sprintf('bitbag_sylius_catalog_plugin.catalog_sorts.%s', $driver), $catalogSortCheckerTypeToLabelMap);
    }
}
