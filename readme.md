# SliMVC

A simple MVC framework, loosely taking inspiration from Laravel and designed to get front end developers up and running quickly. It's based off Slim Framework 2, so is compatible with PHP 5.3.3.

Much of the directory structure has similarities with Laravel. However the `app/` directory is replaced by a much simplified `src/` directory where all the models and controllers live.

Since this is designed as a framework for front-end developers to get started quickly it comes with some tools out of the box:

* A gulp build process for generating the following:
    * SVG sprite building with PNG fallback
    * PNG sprite (if you'd prefer not to use SVGs) - untested
    * SASS compilation
    * Javascript dependency concatenation
    * Javascript minification
    * Watch task that auto-updates based on file changes
* Basic SASS structure with useful mixins included
* Twig support for templating
* Basic view structure for handling layouts, partials and pages.
* Views for adding standard/Facebook/Twitter meta to pages through Twig variables in pages.
* Bower pre-configured for front-end dependencies.

I use this professionally so hopefully it will improve over time as the requirements increase, there'll be updates.

## Contents

* [Requirements](#requirements)
* [Getting Started](#getting-started)
    * [Installation and Setup](#installation)
    * [Routing](#routing)
    * [Controllers](#controllers)
    * [Models](#models)
    * [Views](#views)
    * [Assets](#assets)
    * [Build Configuration](#build-configuration)
* [Planned Features](#planned-features)
* [Known Issues](#known-issues)

<a name="requirements"></a>
## Requirements

* PHP >= 5.3.3
* Composer
* Node.js and NPM
* Bower
* Webserver software such as Apache or Nginx

<a name="getting-started"></a>
## Getting Started

<a name="installation"></a>
### Installation and Setup

You can either use the following [bash script on gist](https://gist.github.com/archy-bold/119ff3c7752a9fcbba51) to install your project, or follow the below steps.

1. Clone the repositry
2. Run composer in the created directory.
    ```bash
    composer install
    ```
3. Run bower to get the javascript dependencies.
    ```bash
    bower install
    ```
4. Run npm to get the build tools.
    ```bash
    npm install
    ```
5. Run the build tools, this compiles the javascript, CSS from SASS and generates the sprites. Once started this runs forever and watches for changes. It's a bit buggy so might need restarting if you add new files. Use Ctrl + C to stop.
    ```bash
    gulp
    ```
6. Ensure the `storage/` directory is writable by the web user. Give it permissions of at least `755`.

<a name="routing"></a>
### Routing

You can define routes in `public/index.php` with the following code. You should always reference functions as `Controller@function`.

```php
$route->get('/', 'PagesController@index');
$route->get('/agencies', 'PagesController@agencies');
```

<a name="controllers"></a>
### Controllers

There is already a `WelcomeController` defined in the `src/Controller/` directory. All controllers must be defined in this directory and follow the pattern set out below. Where the class extends `AbstractController` and the action functions are `public` and should all render a page in `resources/views/`.

```php
<?php namespace App\Controller;

class WelcomeController extends AbstractController{
	
	public function index(){
		$this->render('pages/welcome.html', array(
			'page'       => 'welcome',
			'url'        => url('/'),
			'meta_image' => url('/assets/img/metaimage.png'),
		));
	}

}
```

<a name="models"></a>
### Models

Models are kept in the `src/Model/` directory and use the namespace `App/Model` namespace. There is currently no standard to follow for models and can be normal PHP classes. Feel free to move models wherever required.

<a name="views"></a>
### Views

Views are kept in the `resources/views/` directory and there's an existing directory structure in place, although you can override this as you wish. Views use [Twig templating engine](http://twig.sensiolabs.org/) to allow views to be separated from business logic and other partial views. The `layout.html` file is the main Twig scaffolding that all pages extend.

A page `welcome.html` has already been defined and can be used as a base for new pages. It simply extends `layout.html`, defines meta to be used by search engines, Facebook and Twitter and all HTML content is placed in the `content` block.

```Twig
{% extends "layout.html" %}

{# Define the meta #}
{% set meta_title = 'SliMVC' %}
{% set meta_description = '' %}
{% set meta_keywords = '' %}
{# Open Graph #}
{% set og_title = 'Welcome' %}
{% set og_description = meta_description %}
{% set og_type = 'website' %}
{% set og_image = meta_image %}
{% set og_url = url %}
{% set og_site = 'SliMVC' %}
{# Twitter #}
{% set tw_type = 'summary' %}
{% set tw_user = '' %}
{% set tw_title = 'SliMVC' %}
{% set tw_description = meta_description %}
{% set tw_image = meta_image %}
{# End meta #}

{% block content %}
<h1>Welcome</h1>
{% endblock %}
```

<a name="assets"></a>
### Assets

Assets (javascript, CSS/SASS, images, fonts) are kept in the `resources/` directory when uncompiled and `public/` when ready to serve. Usually that means sprites, SASS and javascript go in `resources/` and ready-to-serve images, fonts, etc should go in `public/`.

#### SASS

There are two SASS files which get compiled from the source in `resources/sass/`, `app.scss` and `app-ie.scss`. The former simply imports everything defined in `_all.scss` (all your styles) and the latter disables media queries and includes an extra file `_ie-hacks.scss` to allow old IE hacks to be included.

#### JavaScript

You should write application javascript in `resources/js/app.js` as this gets minified by the build process and moved to the `public/` directory.

#### Sprites

Place SVG sprites in `resources/sprites/svg/`. SVG sprites should fit within the artboards, not overlap the edges and be the size you wish them to be in the page.

<a name="build-configuration"></a>
### Build Configuration

You can define the configuration for the build process in the `project.json` folder such as where your assets are kept:

```json
{
    ...
    "resources": {
		"scss": "./resources/sass",
		"js": "./resources/js",
		"sprites": "./resources/sprites",
		"bower": "./bower_components"
	},
	...
}
```

As well as the javascript dependencies for the application. Each of these files are compiled into a single `dependecies.min.js` file to reduce the number of HTTP requests. The order that the files are included could be important if some libraries depend on others. You can add your own custom dependencies if needed too.

```json
{
    ...
	"dependencies": [
		"./bower_components/jquery/dist/jquery.min.js",
		"./bower_components/underscore/underscore-min.js",
		"./resources/js/vendor/flickity.js"
	],
	...
}
```

And also where the assets are compiled to, if you're not happy with the current setup:

```json
{
    ...
	"build": {
		"css": "./public/assets/css",
		"js": "./public/assets/js",
		"sprites": "./public/assets/img"
	}
}
```

<a name="planned-features"></a>
## Planned Features

* 404 Errors
* Application configuration and environmental configuration
* Database integration
* Elixir implementation
* Eloquent/better model implementation

<a name="known-issues"></a>
## Known Issues

* Cannot be used in website subfolder
* Requires some fiddling to work in a non-standard directory structure. The frameworks sits above the `public/` directory.
* Untested PNG sprite implementation
* Gulp watch task bugs that crash compilation 
