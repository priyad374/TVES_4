# coverage-check

<p align="center">
    <img src="https://static.permafrost.dev/images/coverage-check/coverage-check-logo-alt.png" alt="coverage-check logo" height="200" style="block">
    <br><br>
    <img src="https://img.shields.io/packagist/v/permafrost-dev/coverage-check.svg" alt="Packagist Version">
    <img src="https://img.shields.io/github/license/permafrost-dev/coverage-check.svg" alt="license">
    <img src="https://github.com/permafrost-dev/coverage-check/actions/workflows/run-tests.yml/badge.svg" alt="Test Run Status">
</p>

---

Enforce a minimum code coverage percentage using a clover.xml file.  Designed to be used in your CI/CD process.

The concept for this package is based on [this article](https://ocramius.github.io/blog/automated-code-coverage-check-for-github-pull-requests-with-travis/).

---

## Installation

```bash
composer require permafrost-dev/coverage-check --dev
```

## Usage

Specify a valid clover.xml file and a minimum coverage percentage to require.  A percentage can be either a whole number (integer) or a decimal (float).

The check will fail if coverage is below the percentage you provide and the process exit code will be non-zero.

```bash
./vendor/bin/coverage-check clover.xml 75
./vendor/bin/coverage-check clover.xml 80.5
```

## Sample Output

TODO

## Sample Github Workflow

```yaml
name: run-tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ${{ matrix.os }}
    strategy:
      fail-fast: true
      matrix:
        os: [ubuntu-latest]
        php: [8.0, 7.4, 7.3]

    name: P${{ matrix.php }} - ${{ matrix.stability }} - ${{ matrix.os }}

    steps:
      - name: Checkout code
        uses: actions/checkout@v2

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: ${{ matrix.php }}
          extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, pdo_sqlite, bcmath, soap, intl, gd, exif, iconv, imagick, fileinfo
          coverage: none

      - name: Setup problem matchers
        run: |
          echo "::add-matcher::${{ runner.tool_cache }}/php.json"
          echo "::add-matcher::${{ runner.tool_cache }}/phpunit.json"

      - name: Install dependencies
        run: composer update --prefer-stable --prefer-dist --no-interaction

      - name: Execute tests
        run: ./vendor/bin/phpunit --coverage-clover clover.xml

      - name: Enforce 75% code coverage
        run: ./vendor/bin/coverage-check clover.xml 75
```

## Testing

```bash
./vendor/bin/phpunit
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Patrick Organ](https://github.com/patinthehat)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.