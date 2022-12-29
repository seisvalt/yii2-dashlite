<?php

namespace andresbreads\dashlite\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DashLiteAsset extends AssetBundle
{
    public $sourcePath = '@andresbreads/dashlite/assets';
    public $css = [
        "css/dashlite.css",
        "css/theme.css",
    ];
    public $js = [
        "js/bundle.js",
        "js/scripts.js",
    ];
    public $depends = [
        BaseAsset::class,
        SimplebarAsset::class,
        DatatablesAsset::class,
    ];
}