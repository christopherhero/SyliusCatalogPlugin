<?php

namespace Acme\SyliusExamplePlugin\Entity\Catalog;

class Catalog implements CatalogInterface
{
    private  $id;

    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }
}
