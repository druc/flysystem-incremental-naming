# flysystem-incremental-naming

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Flysystem plugins to increment file names when dealing with duplicates

## Install

Via Composer

``` bash
$ composer require druc/flysystem-incremental-naming
```

## Usage

``` php
<?php
use Druc\Flysystem\IncrementalNaming\IncrementedCopy;
use Druc\Flysystem\IncrementalNaming\IncrementedRename;
use Druc\Flysystem\IncrementalNaming\IncrementedPath;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

include __DIR__ . '/vendor/autoload.php';

$adapter = new Local(__DIR__ . '/my-dir');
$this->filesystem = new Filesystem($adapter);
$this->filesystem->addPlugin(new IncrementedCopy);
$this->filesystem->addPlugin(new IncrementedRename);
$this->filesystem->addPlugin(new IncrementedPath);

$filesystem = new Filesystem($adapter);

// Filenames will be incremented when copying/renaming into a directory containing the same filename
$filesystem->incrementedCopy('mydir/file', 'other-dir/file'); // 'other-dir/file_1'
$filesystem->incrementedRename('mydir/file', 'other-dir/file'); // 'other-dir/file_1'

// This returns 'other-dir/file_2' if 'file' and 'file_1' are already present
$filesystem->getIncrementedPath('other-dir/file');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email druc@pinsmile.com instead of using the issue tracker.

## Credits

- [Constantin Druc][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/druc/flysystem-incremental-naming.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/druc/flysystem-incremental-naming/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/druc/flysystem-incremental-naming.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/druc/flysystem-incremental-naming.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/druc/flysystem-incremental-naming.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/druc/flysystem-incremental-naming
[link-travis]: https://travis-ci.org/druc/flysystem-incremental-naming
[link-scrutinizer]: https://scrutinizer-ci.com/g/druc/flysystem-incremental-naming/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/druc/flysystem-incremental-naming
[link-downloads]: https://packagist.org/packages/druc/flysystem-incremental-naming
[link-author]: https://github.com/druc
[link-contributors]: ../../contributors
