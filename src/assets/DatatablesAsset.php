<?php

namespace andresbreads\dashlite\assets;

use yii\web\AssetBundle;

class DatatablesAsset extends AssetBundle
{
    public $css = [
        'https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css'
    ];
    public $js = [
        'https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js',
        'https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js',
    ];
}