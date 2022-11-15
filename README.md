# Vanilla Components Integration with Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/flavorly/laravel-vanilla-components.svg?style=flat-square)](https://packagist.org/packages/flavorly/laravel-vanilla-components)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/flavorly/laravel-vanilla-components/run-tests?label=tests)](https://github.com/flavorly/laravel-vanilla-components/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/flavorly/laravel-vanilla-components/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/flavorly/laravel-vanilla-components/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/flavorly/laravel-vanilla-components.svg?style=flat-square)](https://packagist.org/packages/flavorly/laravel-vanilla-components)

A package to integrate vanilla components into Laravel. Specially Datatables & other fields.

## Installation

You can install the package via composer:

```bash
composer require flavorly/laravel-vanilla-components
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-vanilla-components-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-vanilla-components-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-vanilla-components-views"
```

Optionally, you can publish translations using

```bash
php artisan vendor:publish --tag="laravel-vanilla-components-translations
```

## Usage

```php
$vanillaComponents = new VanillaComponents();
echo $vanillaComponents->echoPhrase('Hello, VanillaComponents!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [indigit](https://github.com/indigit)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
