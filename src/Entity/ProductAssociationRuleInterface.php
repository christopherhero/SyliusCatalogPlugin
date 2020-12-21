<?php

declare(strict_types=1);

namespace BitBag\SyliusCatalogPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface ProductAssociationRuleInterface extends ResourceInterface, ConfigurableCatalogElementInterface
{
    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getConfiguration(): array;

    public function setConfiguration(array $configuration): void;

    public function getCatalog(): ?CatalogInterface;

    public function setCatalog(?CatalogInterface $catalog): void;
}
