<?php
namespace Wonderboy\Mustache;

trait ModulesLoader {
  protected $templatePath;
  protected $partialsPath;
  protected $engine;
  protected $config;

  public function setTemplatePath( $path ) {
    $this->templatePath = $path;
  }

  public function setPartialsPath( $path ) {
    $this->partialsPath = $path;
  }

  /**
  *
  * @return \Mustache_Loader_FilesystemLoader
  */
  public function getLoader() {
    if ( ! $this->templatePath ) {
      $this->templatePath = getenv('MUSTACHE_CSS_DIR');
    }
    return new Loader( $this->templatePath );
  }

  /**
   *
   * @return \Mustache_Loader_FilesystemLoader
   */
  public function getPartialsLoader() {
    if ( ! $this->partialsPath ) {
      $this->partialsPath = getenv('MUSTACHE_CSS_DIR');
    }
    return new Loader( $this->partialsPath );
  }

  public function setConfig( array $config = [] ) {
    $this->config = array_merge( [
      'pragmas' => [
        \Mustache_Engine::PRAGMA_BLOCKS
      ],
      'loader' => $this->getLoader(),
      'partials_loader' => $this->getPartialsLoader()
    ], $config );
  }

  public function getConfig() {
    if ( ! $this->config ) {
  	   $this->setConfig();
    }

    return $this->config;
  }

  /**
   *
   * @return \Mustache_Engine
   */
  public function getEngine() {
    if ( ! isset( $this->engine ) ) {
      $this->engine = new \Mustache_Engine( $this->getConfig() );
    }
    return $this->engine;
  }

  /**
   *
   * @param string $template
   * @param array $data
   * @return string
   */
  public function render( $template, $data ) {
    return $this->getEngine()->render( $template, $data );
  }

  public function getCssModules() {
    return $this->getEngine()->getLoader()->getCssModules() . PHP_EOL .
      $this->getEngine()->getPartialsLoader()->getCssModules();
  }

  public function resetCssModules() {
    $this->getEngine()->getLoader()->resetCssModules();
    $this->getEngine()->getPartialsLoader()->resetCssModules();
  }
}
