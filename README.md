# mustache-css-modules

Use CSS Modules in mustache templates

The `example` folder contains an example implementation.

## Install

```sh
$ composer require wonderboymusic/mustache-css-modules
```

Move the contents of the `js/` folder in this repository to the root of your project, then:

```js
$ npm i
```

## Environment

You must set `MUSTACHE_CSS_DIR` in your application's environment. The value will be used to look for Mustache templates and the SCSS files that reside next to them.

JavaScript files check for this directory relative to project root:

```js
const cssDir = path.join(__dirname, process.env.MUSTACHE_CSS_DIR);
```

PHP files look for the absolute path the folder containing your Mustache templates:

```php
$cssDir = getenv('MUSTACHE_CSS_DIR');
```

Before autoloading, you can set this value directly in your bootstrap file:

```php
putenv('MUSTACHE_CSS_DIR=' . __DIR__ . '/src/templates');

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/app.php';
```

## Usage

Let's say you have a bunch of Mustache templates in a folder named `src/templates`. If you have a `footer.mustache` file, add a `footer.scss` file in the same folder.

```
src/templates/footer.mustache
src/templates/footer.scss
```

Styles declared in `footer.scss` will be scoped to `footer.mustache`, so you don't need to worry about global name collision. All of the class names you declare can be available to your view logic, and will be unique, so you also don't need to worry about the CSS cascade or nesting selectors.

First, declare your styles:

```css
/* footer.scss */

.wrap {
  display: block;
  margin: 0 auto;
  width: 780px;
}
```

Use the value of `.wrap` inside of your Mustache template:

```html
<footer class="{{ css.footer.wrap }}">Copyright &copy; 2019</footer>
```

Use `footer` as a template in a Mustache file (e.g. `home.mustache`):

```html
<!doctype html>
<html>
<head>
  <title>Mustache + CSS Modules = 🤯</title>
</head>
<body>
  <main class="{{ css.main.wrapper }}">
  Some body content on a page that has a footer.
  </main>
  {{> footer }}
</body>
</html>
```

Before all of this will actually work, your PHP view logic needs to expose `css` to the template:

```php
use Wonderboy\Mustache\ModulesLoader;
use Wonderboy\Mustache\Template\Utils;

class App {
  use ModulesLoader;

  public function run() {
    $css = Utils::getCSSMap();
    $html = $this->render('main', [ 'css' => $css ]);
    // call after rendering to get collected styles
    // only partials that are part of the render have their styles collected
    $styles = $this->getCssModules();
    // at this point, you can do whatever you want with the output and with the styles
    // I prefer to insert them directly into the <head>, at the end
    $output = str_replace( '</head>', $styles . PHP_EOL . '</head>', $html );

    // probably unnecessary, but you can reset the CSS Modules
    // $this->resetCssModules();

    // more logic?
    echo $output;
  }
}

$app = new App();
$app->run();
```

## Development

Run Gulp to automatically generate the build artifacts that make this all work:

```
$ npm run dev
```
