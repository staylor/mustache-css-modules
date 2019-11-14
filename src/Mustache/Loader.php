<?php
namespace Wonderboy\Mustache;

class Loader extends \Mustache_Loader_FilesystemLoader {
  protected $cssModules = [];

  public function getCssModules() {
    return join(PHP_EOL, array_filter($this->cssModules));
  }

  public function resetCssModules() {
    $this->cssModules = [];
  }

  protected function loadFile($name)
  {
    $fileName = $this->getFileName($name);
    if ($this->shouldCheckPath() && !file_exists($fileName)) {
      throw new \Mustache_Exception_UnknownTemplateException($name);
    }
    if (!array_key_exists($name, $this->cssModules)) {
      $this->cssModules[$name] = null;
      $cssDir = getenv('MUSTACHE_CSS_DIR') . '/';
      $info = pathinfo($fileName);
      $relative = str_replace([$cssDir, '.' . $info['extension']], ['', '.css'], $fileName);
      $cssFile = $cssDir . '.css-modules/' . $relative;
      if (file_exists($cssFile)) {
        $contents = file_get_contents($cssFile);
        if ($contents) {
          $this->cssModules[$name] = '<style data-name="' . $name . '">' . $contents . '</style>';
        }
      }
    }
    return file_get_contents($fileName);
  }
}
