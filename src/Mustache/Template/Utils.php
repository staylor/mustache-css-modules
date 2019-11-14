<?php
namespace Wonderboy\Mustache\Template;

class Utils {
  public static function getCSSMap() {
    $path = getenv('MUSTACHE_CSS_DIR');
    $css = [];
    $dir = new \RecursiveDirectoryIterator($path . '/.css-modules');
    $ite = new \RecursiveIteratorIterator($dir);
    $files = new \RegexIterator($ite, '#.+\.json$#', \RegexIterator::GET_MATCH);

    $modules = [];
    foreach ( $files as list( $module ) ) {
      $info = pathinfo($module);
      $key = str_replace('.' . $info['extension'], '', $info['basename']);
      $css[$key] = json_decode(file_get_contents($module));
    }
    return $css;
  }
}
