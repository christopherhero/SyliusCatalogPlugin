<h1 align="center">
    <a href="http://bitbag.shop" target="_blank">
        <img src="doc/logo.png" width="55%" />
    </a>
    <br />
    <a href="https://packagist.org/packages/bitbag/catalog-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/bitbag/catalog-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/bitbag/catalog-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/bitbag/catalog-plugin.svg" />
    </a>
    <a href="http://travis-ci.org/BitBagCommerce/SyliusCatalogPlugin" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/BitBagCommerce/SyliusCatalogPlugin/master.svg" />
    </a>
    <a href="https://scrutinizer-ci.com/g/BitBagCommerce/SyliusCatalogPlugin/" title="Scrutinizer" target="_blank">
        <img src="https://img.shields.io/scrutinizer/g/BitBagCommerce/SyliusCatalogPlugin.svg" />
    </a>
    <a href="https://packagist.org/packages/bitbag/catalog-plugin" title="Total Downloads" target="_blank">
        <img src="https://poser.pugx.org/bitbag/catalog-plugin/downloads" />
    </a>
    <p>
        <img src="https://sylius.com/assets/badge-approved-by-sylius.png" width="85">
    </p>
</h1>

## About us

At BitBag we do believe in open source. However, we are able to do it just because of our awesome clients, who are kind enough to share some parts of our work with the community. Therefore, if you feel like there is a possibility for us working together, feel free to reach us out. You will find out more about our professional services, technologies and contact details at https://bitbag.io/.

## BitBag SyliusCatalogPlugin

Allows for displaying catalog with products - calculated dynamically with rules. 

For catalog You can configure:

 * code 
 * names, when it should be shown
 * when it should be shown - this is useful for time restricted special offers or promotions
 * there is set of rules that restrict which products will be shown inside, they can be combined using AND or OR.
 * there is another set of rules - used to restrict products associated with given catalog - it can be shown on product details page

## Documentation

- [Installation](doc/installation.md)

## Usage

Plugin provides 2 new twig functions which can be used inside templates:
 * for rendering catalogs by their code:
```html
    {{ bitbag_render_product_catalog("test_catalog") }}
```
 * for rendering all catalogs active for given product
```html
        {{ bitbag_render_product_catalogs(product) }}
```




## Contribution

Learn more about our contribution workflow on http://docs.sylius.org/en/latest/contributing/.
