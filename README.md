Laravel LogViewer
=================


[![Build Status](https://img.shields.io/travis/GrahamCampbell/Laravel-LogViewer/master.svg)](https://travis-ci.org/GrahamCampbell/Laravel-LogViewer)
[![Coverage Status](https://img.shields.io/coveralls/GrahamCampbell/Laravel-LogViewer/master.svg)](https://coveralls.io/r/GrahamCampbell/Laravel-LogViewer)
[![Software License](https://img.shields.io/badge/license-Apache%202.0-brightgreen.svg)](https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md)
[![Latest Version](https://img.shields.io/github/release/GrahamCampbell/Laravel-LogViewer.svg)](https://github.com/GrahamCampbell/Laravel-LogViewer/releases)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-LogViewer/badges/quality-score.png?s=f5a91dbe1dd7a7e2fbdd12d3bd61ab02868b2792)](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-LogViewer)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/2649702d-f080-429b-b17c-dacba1c4c15a/mini.png)](https://insight.sensiolabs.com/projects/2649702d-f080-429b-b17c-dacba1c4c15a)


## What Is Laravel LogViewer?

Laravel LogViewer provides a LogViewer admin module for [Laravel 4.1](http://laravel.com).

* Laravel LogViewer was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell).
* Laravel LogViewer relies on a few of my packages including [Laravel Core](https://github.com/GrahamCampbell/Laravel-Core) and [Laravel Viewer](https://github.com/GrahamCampbell/Laravel-Viewer).
* Laravel LogViewer uses [Travis CI](https://travis-ci.org/GrahamCampbell/Laravel-LogViewer) with [Coveralls](https://coveralls.io/r/GrahamCampbell/Laravel-LogViewer) to check everything is working.
* Laravel LogViewer uses [Scrutinizer CI](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-LogViewer) and [SensioLabsInsight](https://insight.sensiolabs.com/projects/2649702d-f080-429b-b17c-dacba1c4c15a) to run additional checks.
* Laravel LogViewer uses [Composer](https://getcomposer.org) to load and manage dependencies.
* Laravel LogViewer provides a [change log](https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-LogViewer/releases), and [api docs](http://grahamcampbell.github.io/Laravel-LogViewer).
* Laravel LogViewer is licensed under the Apache License, available [here](https://github.com/GrahamCampbell/Laravel-LogViewer/blob/master/LICENSE.md).


## System Requirements

* PHP 5.4.7+ or HHVM 3.0+ is required.
* You will need [Laravel 4.1](http://laravel.com) because this package is designed for it.
* You will need [Composer](https://getcomposer.org) installed to load the dependencies of Laravel LogViewer.


## Installation

Please check the system requirements before installing Laravel LogViewer.

To get the latest version of Laravel LogViewer, simply require `"graham-campbell/logviewer": "0.1.*@dev"` in your `composer.json` file. You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

You will need to register a few service providers before you attempt to load the Laravel LogViewer service provider. Open up `app/config/app.php` and add the following to the `providers` key.

* `'Lightgear\Asset\AssetServiceProvider'`
* `'GrahamCampbell\Core\CoreServiceProvider'`
* `'GrahamCampbell\Viewer\ViewerServiceProvider'`

Once Laravel LogViewer is installed, you need to register the service provider. Open up `app/config/app.php` and add the following to the `providers` key.

* `'GrahamCampbell\LogViewer\LogViewerServiceProvider'`


## Configuration

Laravel LogViewer supports optional configuration.

To get started, first publish the package config file:

    php artisan config:publish graham-campbell/logviewer

There are two config options:

**Filters**

This option (`'filters'`) defines the filters to be put in front of the endpoints provided by this package. A common use will be for your own authentication filters. The default value for this setting is `array()`.

**Per Page**

This option (`'per_page'`) defines defines how many log entries are displayed per page. The default value for this setting is `20`.


## Usage

There is currently no usage documentation besides the [API Documentation](http://grahamcampbell.github.io/Laravel-LogViewer
) for Laravel LogViewer.


## Updating Your Fork

Before submitting a pull request, you should ensure that your fork is up to date.

You may fork Laravel LogViewer:

    git remote add upstream git://github.com/GrahamCampbell/Laravel-LogViewer.git

The first command is only necessary the first time. If you have issues merging, you will need to get a merge tool such as [P4Merge](http://perforce.com/product/components/perforce_visual_merge_and_diff_tools).

You can then update the branch:

    git pull --rebase upstream master
    git push --force origin <branch_name>

Once it is set up, run `git mergetool`. Once all conflicts are fixed, run `git rebase --continue`, and `git push --force origin <branch_name>`.


## Pull Requests

Please review these guidelines before submitting any pull requests.

* When submitting bug fixes, check if a maintenance branch exists for an older series, then pull against that older branch if the bug is present in it.
* Before sending a pull request for a new feature, you should first create an issue with [Proposal] in the title.
* Please follow the [PSR-2 Coding Style](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) and [PHP-FIG Naming Conventions](https://github.com/php-fig/fig-standards/blob/master/bylaws/002-psr-naming-conventions.md).


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
