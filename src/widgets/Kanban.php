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

class Kanban extends \yii\base\Widget
{
    public $element;
    public $varName;
    public $widthBoard = '320px';
    public $responsivePercentage = false;
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
        $view->registerJs("$(function() {
            \"use strict\";

            const openKanban = function () {
                var {$this->varName} = new jKanban({
                    element: '{$this->element}',
                    gutter: '0',
                    widthBoard: '{$this->widthBoard}',
                    responsivePercentage: {$this->responsivePercentage},
                    boards: {$this->boardsJson}
                });
            }

            openKanban()
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
                'item' => $board['item'],
            ];
        }

        $this->boardsJson = Json::encode($boards);
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