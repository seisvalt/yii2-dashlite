<?php
namespace andresbreads\dashlite\widgets;

use Yii;
use yii\base\InvalidCallException;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * {@inheritDoc}
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    /**
     * {@inheritDoc}
     */
    public $fieldClass = 'andresbreads\dashlite\widgets\ActiveField';

    /**
     * {@inheritDoc}
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        \andresbreads\dashlite\assets\DashLiteAsset::register($view);
    }
}