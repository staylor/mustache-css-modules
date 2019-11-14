# mustache-css-modules

Use CSS Modules in mustache templates

WARNING: THIS DOES NOT WORK YET. I EXTRACTED IT FROM A PROJECT JUST TO ISOLATE IT IN A REPO. I HAVE LITERALLY NEVER RUN THE CODE IN ITS CURRENT FORM. DO NOT USE IT.

## Install

```sh
$ composer require wonderboymusic/mustache-css-modules
```

Move the contents of the `js/` folder in this repository to the root of your project, then:

```js
$ npm i
```

## Environment

You must set `MUSTACHE_CSS_DIR` in your application's environment. The value will be used to look for Mustache partials and the SCSS files that reside next to them.

JavaScript files check for:

```js
const cssDir = process.env.MUSTACHE_CSS_DIR;
```

PHP files look for:

```php
$cssDir = getenv('MUSTACHE_CSS_DIR');
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

Use `footer` as a partial in a Mustache file (assume `home.mustache`):

```html
<!doctype html>
<html>
<head>
  <title>Mustache + CSS Modules = 🤯</title>
</head>
<body>
Some body content on a page that has a footer.

{{> footer }}
</body>
</html>
```

Before this will work, your PHP view logic needs to expose `css` to the template:

```php
namespace YourApp;

use Wonderboy\Mustache\ModulesLoader;
use Wonderboy\Mustache\Template\Utils;

class Router {
  use ModulesLoader;

  public function route() {
    // logic that determines we want to render "home"

    $css = Utils::getCSSMap();
    $rendered = $this->render('home', [ 'css' => $css ]);
    // call after rendering to get collected styles
    // only partials that are part of the render have their styles collected
    $styles = $this->getCssModules();
    // at this point, you can do whatever you want with the output and with the styles
    // I prefer to insert them directly into the <head>, at the end
    $output = str_replace( '</head>', $styles . PHP_EOL . '</head>', $rendered );

    // probably unnecessary, but you can reset the CSS Modules
    // $this->resetCssModules();

    // more logic?
    echo $output
  }
}
```
