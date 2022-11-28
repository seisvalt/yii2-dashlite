<?php
namespace andresbreads\dashlite\widgets;

use yii\helpers\ArrayHelper;
use yii\bootstrap5\Html;
use yii\helpers\Url;

/**
 * Class Menu
 * @package andresbreads\dashlite\widgets
 *
 * For example,
 *
 * ```php
 * Menu::widget([
 *      'items' => [
 *          [
 *              'label' => 'Starter Pages',
 *              'icon' => 'meter',
 *              'badge' => '2',
 *              'items' => [
 *                  ['label' => 'Active Page', 'url' => ['site/index']],
 *                  ['label' => 'Inactive Page'],
 *              ]
 *          ],
 *          ['label' => 'Simple Link', 'icon' => 'list-index', 'badge' => 'New'],
 *          ['label' => 'Yii2 PROVIDED', 'header' => true],
 *          ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
 *          ['label' => 'Debug', 'icon' => 'bugs', 'url' => ['/debug'], 'target' => '_blank'],
 *          ['label' => 'Important'],
 *          ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
 *      ]
 * ])
 * ```
 *
 * @var array menu item
 * - label: string, the menu item label.
 * - header: boolean, not nav-item but nav-header when it is true.
 * - url: string or array, it will be processed by [[Url::to]].
 * - items: array, the sub-menu items.
 * - icon: string, the icon name of DashLite handcrafted icons. @see https://dashlite.net/demo1/components/misc/nioicon.html
 * - iconClass: string, the whole icon class.
 * - badge: string.
 * - target: string.
 */
class Menu extends \yii\widgets\Menu
{
    /**
     * @inheritdoc
     */
    public $linkTemplate = '<a class="nk-menu-link {submenuClass}" href="{url}" {target}>{icon} {label}</a>';

    /**
     * @inheritdoc
     */
    public $labelTemplate = '{label} {badge}';

    /**
     * @var string submenu wrapper
     */
    public $submenuTemplate = "\n<ul class='nk-menu-sub'>\n{items}\n</ul>\n";

    /**
     * @var string
     */
    public $activeCssClass = 'active current-page';

    /**
     * @var string
     */
    public static $iconDefault = 'circle';

    /**
     * @inheritdoc
     */
    public $itemOptions = ['class' => 'nk-menu-item'];

    /**
     * @inheritdoc
     */
    public $activateParents = true;

    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'nk-menu',
        'role' => 'menu',
    ];

    /**
     * {@inheritDoc}
     */
    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));

            if (isset($item['items'])) {
                Html::addCssClass($options, 'has-sub');
            }

            if (isset($item['header']) && $item['header']) {
                Html::removeCssClass($options, 'nk-menu-item');
                Html::addCssClass($options, 'nk-menu-heading');
            }

            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            Html::addCssClass($options, $class);

            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }

            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

    /**
     * {@inheritDoc}
     */
    protected function renderItem($item)
    {
        if(isset($item['header']) && $item['header']) {
            return Html::tag('h6', $item['label'], ['class' => 'overline-title text-primary-alt']);
        }

        if (isset($item['iconClass'])) {
            $iconClass = $item['iconClass'];
        } else {
            $icon = $item['icon'] ?? static::$iconDefault;
            $iconClass = 'icon ni ni-'.$icon;
        }
        $iconHtml = Html::tag('span', '<em class="'.$iconClass.'"></em>', ['class' => 'nk-menu-icon']);

        $template = ArrayHelper::getValue($item, 'template', (isset($item['linkTemplate']))? $item['linkTemplate'] : $this->linkTemplate);
        return strtr($template, [
            '{label}' => strtr($this->labelTemplate, [
                '{label}' => Html::tag('span', $item['label'], ['class' => 'nk-menu-text']),
                '{badge}' => isset($item['badge']) ? Html::tag('span', $item['badge'], ['class' => 'nk-menu-badge']) : '',
            ]),
            '{submenuClass}' => isset($item['items']) ? 'nk-menu-toggle' : '',
            '{url}' => isset($item['url']) ? Url::to($item['url']) : '#',
            '{icon}' => $iconHtml,
            '{target}' => isset($item['target']) ? 'target="'.$item['target'].'"' : ''
        ]);
    }
}