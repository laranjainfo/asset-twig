# Simple Asset Twig Extension

Simple twig function to render assets in twig view

## Installation

Install [Twig][1]

Install the extension:

```composer require laranjainfo/twig-asset```

Add the extension to yout Twig, like this:

```
$twig = new Twig_Environment(...);
$twig->addExtension(new Laranjainfo\TwigExtension\Asset());
```

## Configuration

You can create yout own config file and load with the extension, OR use our default configuration:

To load yout file:

```
	$cfg = [
		'site_url'			=> 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
		'prefix'			=> 'web',
		'version'			=> true,
		'css_dir'			=> 'css',
		'js_dir'			=> 'js',
		'images_dir'		=> 'images',
		'touch_icon_dir'	=> 'icons',
		'manifest_dir'		=> '',
	];

	$twig->addExtension(new Laranjainfo\TwigExtension\Asset($cfg));
```

## Usage

You can use the asset helper with:

- Javascript files;
- CSS files;
- Image files;
- Manifest files;
- Apple-touch-icon files;

_More is coming soon..._

### To directly call styles and scripts:

```{{ asset('style.css') }}``` will call the file inside the config variable ```css_dir```
```{{ asset('vendor/slick.js') }}``` Will call the js file inside the config variable ```js_dir```, and the subfolder ```vendor```

Or call the shorthand of the function:

```{{ _a('style.css') }}```

### To simple call images, use the second parameter __image__

```{{ asset('slider/slide-01.webp', 'image') }}```

Will return:

```<img src="http://site.com/location/of/file/thumb.png">```

### To call image files with parameters:

To call images with parameters, use the ```array``` way:

```{{ asset({ file: 'thumb.png', 'type' : image, params: { class: 'image', alt: 'Aww yeah!!' } }) }}```

will return:

```<img src="http://site.com/location/of/file/thumb.png" class="image" alt="Aww yeah!!">```

### Understanding the usage

There are 4 parameters, that can be used...

Inline...

```asset(file, type, version, params)```

...or by array:

```asset({ file: string, type: string, version: string, params: array })```

[1]: https://github.com/twigphp/Twig
[2]: https://github.com/twigphp/Twig-extensions