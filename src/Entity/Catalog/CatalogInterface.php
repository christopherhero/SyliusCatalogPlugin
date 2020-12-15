<?php

namespace Acme\SyliusExamplePlugin\Entity\Catalog;

use Sylius\Component\Resource\Model\ResourceInterface;

interface CatalogInterface extends ResourceInterface
{
    public function getName();
}
