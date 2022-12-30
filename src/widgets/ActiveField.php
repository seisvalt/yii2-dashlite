<?php
namespace andresbreads\dashlite\widgets;

use Yii;
use yii\base\Component;
use yii\base\ErrorHandler;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * {@inheritDoc}
 */
class ActiveField extends \yii\widgets\ActiveField
{
    /**
     * {@inheritDoc}
     */
    public $template = "{input}\n{label}\n{hint}\n{error}";

    /**
     * {@inheritDoc}
     */
    public $inputOptions = ['class' => 'form-control form-control-outlined'];

    /**
     * {@inheritDoc}
     */
    public $labelOptions = ['class' => 'form-label-outlined control-label'];

    /**
     * @var bool if "for" field label attribute should be skipped.
     */
    private $_skipLabelFor = false;

    /**
     * {@inheritDoc}
     */
    public function begin()
    {
        if ($this->form->enableClientScript) {
            $clientOptions = $this->getClientOptions();
            if (!empty($clientOptions)) {
                $this->form->attributes[] = $clientOptions;
            }
        }

        $inputID = $this->getInputId();
        $attribute = Html::getAttributeName($this->attribute);
        $options = $this->options;
        $class = isset($options['class']) ? (array) $options['class'] : [];
        $class[] = "field-$inputID";
        if ($this->model->isAttributeRequired($attribute)) {
            $class[] = $this->form->requiredCssClass;
        }
        $options['class'] = implode(' ', $class);
        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_CONTAINER) {
            $this->addErrorClassIfNeeded($options);
        }
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        return Html::beginTag($tag, $options).Html::beginTag('div', ['class' => 'form-control-wrap']);
    }

    /**
     * {@inheritDoc}
     */
    public function end()
    {
        return Html::endTag('div').Html::endTag(ArrayHelper::keyExists('tag', $this->options) ? $this->options['tag'] : 'div');
    }

    /**
     * {@inheritDoc}
     */
    public function dropDownList($items, $options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $options['class'] = 'form-select js-select2';

        Html::removeCssClass($options, 'form-control-outlined');
        Html::addCssClass($options, 'form-select');

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function radioList($items, $options = [])
    {
        $this->template = "{label}\n{input}\n{hint}\n{error}";
        $this->labelOptions = ['class' => 'form-label control-label'];

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addRoleAttributes($options, 'radiogroup');
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->_skipLabelFor = true;
        $this->parts['{input}'] = Html::activeRadioList($this->model, $this->attribute, $items, $options);

        return $this;
    }

    public function datePicker($options = [])
    {
        $options['class'] = 'form-control form-control-outlined date-picker';
        if (!isset($options['format'])) {
            $options['data-date-format'] = 'yyyy-mm-dd';
        } else {
            $options['data-date-format'] = $options['format'];
            unset($options['format']);
        }
        $this->textInput($options);

        return $this;
    }
}