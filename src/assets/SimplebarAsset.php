<?php

namespace andresbreads\dashlite\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class SimplebarAsset extends AssetBundle
{
    public $sourcePath = '@vendor/npm-asset/simplebar/dist';
    public $css = [
        "simplebar.min.css",
    ];
    public $js = [
        "simplebar.min.js",
    ];
    public $depends = [
    ];
}