<?php
/**
 * Based on https://github.com/riktar/jkanban
 */

namespace andresbreads\dashlite\widgets;

use andresbreads\dashlite\assets\KanbanAsset;
use yii\base\InvalidConfigException;
use yii\bootstrap5\Html;
use yii\helpers\Json;
use yii\bootstrap5\Dropdown;
use yii\web\JsExpression;

class Kanban extends \yii\base\Widget
{
    public $element;
    public $varName;
    public $widthBoard = '320px';
    public $responsivePercentage = false;
    public $dragItems = true;
    public $boards = [];
    private $boardsJson;

    public function init()
    {
        parent::init();
        if ($this->element === null) {
            $this->element = '#kanbanElement';
        }
        if (!is_string($this->element)) {
            throw new InvalidConfigException('The "element" property must be a string');
        }
        if (!str_contains($this->element, '#')) {
            $this->element = '#'.$this->element;
        }
        if ($this->varName === null) {
            $this->varName = 'kanbanVar';
        }
        if (!is_string($this->varName)) {
            throw new InvalidConfigException('The "varName" property must be a string');
        }
        if (!is_array($this->boards)) {
            throw new InvalidConfigException('The "boards" property must be an array');
        }
    }

    public function run()
    {
        $view = $this->getView();
        KanbanAsset::register($view);
        $this->normalizeBoards();
        $this->responsivePercentage = $this->responsivePercentage ? 'true' : 'false';
        $this->dragItems = $this->dragItems ? 'true' : 'false';
        $view->registerJs("$(function() {
            \"use strict\";

            const openKanban = function () {
                var {$this->varName} = new jKanban({
                    element: '{$this->element}',
                    gutter: '0',
                    widthBoard: '{$this->widthBoard}',
                    responsivePercentage: {$this->responsivePercentage},
                    dragItems: {$this->dragItems},
                    boards: {$this->boardsJson}
                });
            }

            openKanban();

            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle=\"popover\"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })
        });", \yii\web\View::POS_END);
        echo Html::tag('div', '', ['id' => substr($this->element, 1), 'class' => 'nk-kanban']);
        parent::run();
    }

    protected function normalizeBoards()
    {
        $boards = [];
        foreach ($this->boards as $id => $board) {
            if (!isset($board['title']) || !isset($board['titleAmount'])) {
                throw new InvalidConfigException('Every array element in "boards" property must have a "title" and "titleAmount"');
            }
            $showOptions = $board['showOptions'] ?? true;
            if ($showOptions && !isset($board['optionItems'])) {
                throw new InvalidConfigException('When showing options in "board", "optionItems" must be set');
            }
            $optionItems = $board['optionItems'] ?? [];
            $title = $this->renderTitle($board['title'], $board['titleAmount'], $showOptions, $optionItems);
            $boards[] = [
                'id' => $id,
                'title' => $title,
                'class' => $board['class'] ?? 'kanban-primary',
                'item' => $this->normalizeItems($board['item']),
            ];
        }

        $this->boardsJson = Json::encode($boards);
    }

    protected function normalizeItems($items)
    {
        foreach ($items as $key => $item) {
            if (isset($item['click'])) {
                $items[$key]['click'] = $item['click'] instanceof JsExpression ? $item['click'] : new JsExpression($item['click']);
            }
            if (isset($item['context'])) {
                $items[$key]['context'] = $item['context'] instanceof JsExpression ? $item['context'] : new JsExpression($item['context']);
            }
            if (isset($item['dragEl'])) {
                $items[$key]['dragEl'] = $item['dragEl'] instanceof JsExpression ? $item['dragEl'] : new JsExpression($item['dragEl']);
            }
            if (isset($item['dragendEl'])) {
                $items[$key]['dragendEl'] = $item['dragendEl'] instanceof JsExpression ? $item['dragendEl'] : new JsExpression($item['dragendEl']);
            }
            if (isset($item['dropEl'])) {
                $items[$key]['dropEl'] = $item['dropEl'] instanceof JsExpression ? $item['dropEl'] : new JsExpression($item['dropEl']);
            }
            if (isset($item['dragBoard'])) {
                $items[$key]['dragBoard'] = $item['dragBoard'] instanceof JsExpression ? $item['dragBoard'] : new JsExpression($item['dragBoard']);
            }
            if (isset($item['dragendBoard'])) {
                $items[$key]['dragendBoard'] = $item['dragendBoard'] instanceof JsExpression ? $item['dragendBoard'] : new JsExpression($item['dragendBoard']);
            }
            if (isset($item['buttonClick'])) {
                $items[$key]['buttonClick'] = $item['buttonClick'] instanceof JsExpression ? $item['buttonClick'] : new JsExpression($item['buttonClick']);
            }
        }
        return $items;
    }

    protected function renderTitle($title, $titleAmount, $showOptions, $optionItems = [])
    {
        $title = Html::tag('h6', $title, ['class' => 'title']);
        $titleAmount = Html::tag('span', $titleAmount, ['class' => 'badge rounded-pill bg-outline-light text-dark']);
        $titleContainer = Html::tag('div', $title.$titleAmount, ['class' => 'kanban-title-content']);

        $optionsContainer = '';
        if ($showOptions) {
            $dropdownButton = Html::a('<em class="icon ni ni-more-h"></em>', '#', [
                'class' => 'dropdown-toggle btn btn-sm btn-icon btn-trigger me-n1',
                'data-bs-toggle' => 'dropdown'
            ]);
            $dropdownOptions = Dropdown::widget([
                'options' => ['class' => 'dropdown-menu-end'],
                'items' => $optionItems,
            ]);
            $dropdownContainer = Html::tag('div', $dropdownButton . $dropdownOptions, ['class' => 'drodown']);
            $optionsContainer = Html::tag('div', $dropdownContainer, ['class' => 'kanban-title-content']);
        }

        return $titleContainer . $optionsContainer;
    }
}

/* <div class="drodown">
    <div class="dropdown-menu dropdown-menu-end">
        <ul class="link-list-opt no-bdr">
            <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit Board</span></a></li>
            <li><a href="#"><em class="icon ni ni-plus-sm"></em><span>Add Task</span></a></li>
            <li><a href="#"><em class="icon ni ni-plus-sm"></em><span>Add Option</span></a></li>
        </ul>
    </div>
</div> */