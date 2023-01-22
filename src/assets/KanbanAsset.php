<?php

namespace andresbreads\dashlite\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class KanbanAsset extends AssetBundle
{
    public $sourcePath = '@andresbreads/dashlite/assets';
    public $css = [];
    public $js = [
        "js/libs/jkanban.js",
    ];
    public $depends = [
        DashLiteAsset::class
    ];
}