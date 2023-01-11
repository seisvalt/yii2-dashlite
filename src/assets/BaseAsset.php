<?php

namespace andresbreads\dashlite\assets;

use yii\web\AssetBundle;

class BaseAsset extends AssetBundle
{
    public $depends = [
        \yii\bootstrap5\BootstrapAsset::class,
    ];
}