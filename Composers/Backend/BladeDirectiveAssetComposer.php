<?php

namespace Modules\Taxonomy\Composers\Backend;

use Modules\Core\Foundation\Asset\Manager\AssetManager;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;
use Modules\Core\Foundation\Asset\Types\AssetTypeFactory;

class BladeDirectiveAssetComposer
{
  /**
   * @var AssetManager
   */
  private $assetManager;
  /**
   * @var AssetPipeline
   */
  private $assetPipeline;
  /**
   * @var AssetTypeFactory
   */
  private $assetFactory;

  public function __construct()
  {
    $this->assetManager = app(AssetManager::class);
    $this->assetPipeline = app(AssetPipeline::class);
    $this->assetFactory = app(AssetTypeFactory::class);
  }

  public function compose()
  {
    $this->addAssets();
    $this->requireAssets();
  }

  /**
   * Add the assets from the config file on the asset manager
   */
  private function addAssets()
  {
    foreach (config('asgard.taxonomy.assets.register-assets', []) as $assetName => $path) {
      $path = $this->assetFactory->make($path)->url();
      $this->assetManager->addAsset($assetName, $path);
    }
  }

  /**
   * Require assets from asset manager
   */
  private function requireAssets()
  {
    $css = config('asgard.taxonomy.assets.required-assets.css');
    $js  = config('asgard.taxonomy.assets.required-assets.js');

    if (!empty($css)) {
      $this->assetPipeline->requireCss($css);
    }

    if (!empty($js)) {
      $this->assetPipeline->requireJs($js);
    }
  }
}
