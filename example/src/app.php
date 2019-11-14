<?php
use Wonderboy\Mustache\ModulesLoader;
use Wonderboy\Mustache\Template\Utils;

class App {
  use ModulesLoader;

  public function run() {
    $css = Utils::getCSSMap();
    $html = $this->render('main', ['css' => $css]);
    $styles = $this->getCssModules();
    $output = str_replace( '</head>', $styles . PHP_EOL . '</head>', $html );

    echo $output;
  }
}

$app = new App();
$app->run();
