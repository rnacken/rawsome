# [Rawsome](https://github.com/rnacken/rawsome)

Rawsome is:
* a Wordpress installation with some excellent plugins built in.
* a clean starter theme with some modern best-practices built in. This theme is mostly based on Sage, by Roots (https://github.com/roots/sage)

## Requirements

| Prerequisite    | How to check | How to install
| --------------- | ------------ | ------------- |
| PHP >= 5.4.x    | `php -v`     | [php.net](http://php.net/manual/en/install.php) |
| composer >= 1.2.3 | `composer --version` | [getcomposer.org](https://getcomposer.org/) |
| Node.js 0.12.x  | `node -v`    | [nodejs.org](http://nodejs.org/) |
| gulp >= 3.8.10  | `gulp -v`    | `npm install -g gulp` |
| Bower >= 1.3.12 | `bower -v`   | `npm install -g bower` |

For more installation notes, refer to the [Install gulp and Bower](#install-gulp-and-bower) section in this document.

## Features

* [composer](https://getcomposer.org/) build Wordpress in separate wp-folder, install plugins, place must-use plugins in correct folder and activate them automatically
* Nice search (`/search/query/`)
* Google CDN jQuery snippet from [HTML5 Boilerplate](http://html5boilerplate.com/)
* Google Analytics snippet from [HTML5 Boilerplate](http://html5boilerplate.com/)
* Pre installed multilanguage (qtranslateX)
* Pre installed Advanced Custom Fields Pro
* Pre installed Custom Admin Columns (+acf addon)
* Additions for wordpress Rest API

### Stuff from Roots theme
* [gulp](http://gulpjs.com/) build script that compiles both Sass and Less, checks for JavaScript errors, optimizes images, and concatenates and minifies files
* [BrowserSync](http://www.browsersync.io/) for keeping multiple browsers and devices synchronized while testing, along with injecting updated CSS and JS into your browser while you're developing
* [Bower](http://bower.io/) for front-end package management
* [asset-builder](https://github.com/austinpray/asset-builder) for the JSON file based asset pipeline
* [Theme wrapper](https://roots.io/sage/docs/theme-wrapper/)


## Installation

* Clone the git repo
* Install wp & plugins with composer (composer install)
* Create a .env file in the root (see .env.example)
* Change themes/rawsome directory name to your project name. Also change theme name in style.css
* Bower install
* Npm install
* Run gulp for creating /dist files

## Further development

### Add a plugin

* In root, edit composer.json file. Add a wpackagist/plugin-name entry
* If it is a mu-plugin, add it to extra twice (once for install-location and once for automatic loading)

## Other stuff

### Using BrowserSync

To use BrowserSync during `gulp watch` you need to update `devUrl` at the bottom of `assets/manifest.json` to reflect your local development hostname.

For example, if your local development URL is `http://project-name.dev` you would update the file to read:
```json
...
  "config": {
    "devUrl": "http://project-name.dev"
  }
...
```
If your local development URL looks like `http://localhost:8888/project-name/` you would update the file to read:
```json
...
  "config": {
    "devUrl": "http://localhost:8888/project-name/"
  }
...
```
