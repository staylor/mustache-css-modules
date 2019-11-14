<?php
namespace Wonderboy\Mustache\Template;

class Utils {
  public static function getCSSMap() {
    $path = getenv('MUSTACHE_CSS_DIR');
    $css = [];
    foreach (glob($path . '/.css-modules/**/*.json') as $module) {
      $info = pathinfo($module);
      $key = str_replace('.' . $info['extension'], '', $info['basename']);
      $css[$key] = json_decode(file_get_contents($module));
    }
    return $css;
  }
}
