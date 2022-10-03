# Konnco Studio personal package to make your development Satset Satset

[![Latest Version on Packagist](https://img.shields.io/packagist/v/konnco/satset.svg?style=flat-square)](https://packagist.org/packages/konnco/satset)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/konnco/satset/run-tests?label=tests)](https://github.com/konnco/satset/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/konnco/satset/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/konnco/satset/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/konnco/satset.svg?style=flat-square)](https://packagist.org/packages/konnco/satset)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/SatSet.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/SatSet)

We invest a lot of resources into creating [Konnco Studio](https://konnco.com). You can support us by.

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require konnco/satset
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="satset-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="satset-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="satset-views"
```

## Usage

```php
$satSet = new Konnco\SatSet();
echo $satSet->echoPhrase('Hello, Konnco!');
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

- [Franky So](https://github.com/Konnco)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
