Laravel LogViewer
=================

Laravel LogViewer was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell), and provides a LogViewer admin module for [Laravel 4.1/4.2](http://laravel.com). It relies on some of my packages including [Laravel Core](https://github.com/GrahamCampbell/Laravel-Core). Feel free to check out the [change log](CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-LogViewer/releases), [license](LICENSE.md), [api docs](http://docs.grahamjcampbell.co.uk), and [contribution guidelines](CONTRIBUTING.md).

![Laravel LogViewer](https://cloud.githubusercontent.com/assets/2829600/4432325/c1934796-468c-11e4-9577-63c1973d6811.PNG)

<p align="center">
<a href="https://travis-ci.org/GrahamCampbell/Laravel-LogViewer"><img src="https://img.shields.io/travis/GrahamCampbell/Laravel-LogViewer/master.svg?style=flat-square" alt="Build Status"></img></a>
<a href="https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-LogViewer/code-structure"><img src="https://img.shields.io/scrutinizer/coverage/g/GrahamCampbell/Laravel-LogViewer.svg?style=flat-square" alt="Coverage Status"></img></a>
<a href="https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-LogViewer"><img src="https://img.shields.io/scrutinizer/g/GrahamCampbell/Laravel-LogViewer.svg?style=flat-square" alt="Quality Score"></img></a>
<a href="LICENSE.md"><img src="https://img.shields.io/badge/license-Apache%202.0-brightgreen.svg?style=flat-square" alt="Software License"></img></a>
<a href="https://github.com/GrahamCampbell/Laravel-LogViewer/releases"><img src="https://img.shields.io/github/release/GrahamCampbell/Laravel-LogViewer.svg?style=flat-square" alt="Latest Version"></img></a>
</p>


## Installation

[PHP](https://php.net) 5.4+ or [HHVM](http://hhvm.com) 3.3+, and [Composer](https://getcomposer.org) are required.

To get the latest version of Laravel LogViewer, simply add the following line to the require block of your `composer.json` file:

```
"graham-campbell/logviewer": "0.2.*"
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

You will need to register a few service providers before you attempt to load the Laravel LogViewer service provider. Open up `app/config/app.php` and add the following to the `providers` key.

* `'Lightgear\Asset\AssetServiceProvider'`
* `'GrahamCampbell\Core\CoreServiceProvider'`

Once Laravel LogViewer is installed, you need to register the service provider. Open up `app/config/app.php` and add the following to the `providers` key.

* `'GrahamCampbell\LogViewer\LogViewerServiceProvider'`


## Configuration

Laravel LogViewer supports optional configuration.

To get started, first publish the package config file:

```bash
$ php artisan config:publish graham-campbell/logviewer
```

There are two config options:

##### Filters

This option (`'filters'`) defines the filters to be put in front of the endpoints provided by this package. A common use will be for your own authentication filters. The default value for this setting is `array()`.

##### Per Page

This option (`'per_page'`) defines defines how many log entries are displayed per page. The default value for this setting is `20`.


## Usage

Laravel LogViewer is designed to work with [Bootstrap CMS](https://github.com/GrahamCampbell/Bootstrap-CMS). In order for it to work in any Laravel application, you must ensure that you have [app/config/platform.php](https://github.com/GrahamCampbell/Laravel-Platform/blob/master/app/config/platform.php) and [app/config/views.php](https://github.com/GrahamCampbell/Laravel-Platform/blob/master/app/config/views.php) correctly configured, and you know how to use my [Laravel Core](https://github.com/GrahamCampbell/Laravel-Core) package as knowledge of the `app:install` and `app:update ` commands is required.

Laravel LogViewer will register four routes. The only one of interest to you is `'logviewer'` (`logviewer.index`) as it will be the main entry point for the use of this package. You can checkout the other three routes in the [source](https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/src/routes.php) if you must.

The internals of Laravel LogViewer are not documented here, but feel free to check out the [API Documentation](http://docs.grahamjcampbell.co.uk).

You may see an example of implementation in [Bootstrap CMS](https://github.com/GrahamCampbell/Bootstrap-CMS).


## License

Apache License

Copyright 2014 Graham Campbell

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
