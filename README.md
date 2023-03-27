# Laravel / Diese Software

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marcbelletre/laravel-diese.svg?style=flat-square)](https://packagist.org/packages/marcbelletre/laravel-diese)
[![Total Downloads](https://img.shields.io/packagist/dt/marcbelletre/laravel-diese.svg?style=flat-square)](https://packagist.org/packages/marcbelletre/laravel-diese)

### This package provides a convenient Laravel wrapper for interacting with the [Diese Software](https://www.diesesoftware.com) API.
### [API Documentation](https://apidoc.diesesoftware.com)

## Installation

You can install the package via composer:

```bash
composer require marcbelletre/laravel-diese
```

## Usage

```php
use MarcBelletre\LaravelDiese\Facades\Diese;

// Use the `get` method to retrieve all records for a content type
$productions = Diese::get('productions');
$cast = Diese::find('production/cast/10');

// Use the `find` method to retrieve a single record by its ID
$production = Diese::find('production', 10);
$productionType = Diese::find('productionType', 2);
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email marc@pixelparfait.fr instead of using the issue tracker.

## Credits

-   [Marc Bellêtre](https://github.com/marcbelletre)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
