<?php
namespace andresbreads\dashlite\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\Html;
use Yii;

/**
 * Class UserDropdown
 * @package andresbreads\dashlite\widgets
 *
 * For example,
 *
 * ```php
 * UserDropdown::widget([
 *      'items' => [
 *          ['label' => 'Messages', 'url' => '/user/messages', 'icon' => 'emails', 'badge' => 42],
 *          ['label' => 'Tasks', 'url' => '/user/tasks', 'icon' => 'task', 'badge' => 31],
 *          ['label' => 'Comments', 'url' => '/user/comments', 'icon' => 'comments', 'badge' => 17],
 *          ['label' => 'Messages', 'url' => '/user/messages', 'icon' => 'emails', 'badge' => 42],
 *          ['label' => 'View Profile', 'url' => '/user/profile', 'icon' => 'user-alt'],
 *          ['label' => 'Account Setting', 'url' => '/user/profile#setting', 'icon' => 'setting-alt'],
 *          ['label' => 'Login Activity', 'url' => '/user/profile#activity', 'icon' => 'activity-alt'],
 *          'dark-switch',
 *      ]
 * ])
 * ```
 *
 * @var array dropdown item
 * - label: string, the dropdown item label.
 * - visible: boolean, whether its visible or not.
 * - encode: boolean, whether it must encode label or not.
 * - url: string or array, it will be processed by [[Url::to]].
 * - icon: string, the icon name of DashLite handcrafted icons. @see https://dashlite.net/demo1/components/misc/nioicon.html
 * - iconClass: string, the whole icon class.
 * - badge: string.
 */
class UserDropdown extends \yii\bootstrap5\Dropdown
{
    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1',
    ];

    public $userRole = 'Administrator';

    public $userFullName = 'Abu Bin Ishtiyak';

    public $userEmail = 'info@softnio.com';

    /**
     * @var string
     */
    public static $iconDefault = 'circle';

    /**
     * @inheritdoc
     */
    public $labelTemplate = '{icon} <span>{label}</span> {badge}';

    /**
     * @inheritdoc
     */
    protected function renderItems(array $items, array $options = []): string
    {
        $lines = [];

        $lines[] = $this->renderUserInfo();

        $links = [];
        $links[] = Html::beginTag('ul', ['class' => 'link-list']);
        foreach ($items as $item) {
            if (is_string($item)) {
                $links[] = ($item === 'dark-switch')
                    ? $this->renderDarkSwitch()
                    : $item;
                continue;
            }

            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }

            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }

            $encodeLabel = $item['encode'] ?? $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            $active = ArrayHelper::getValue($item, 'active', false);
            $disabled = ArrayHelper::getValue($item, 'disabled', false);

            Html::addCssClass($linkOptions, ['widget' => 'dropdown-item']);
            if ($disabled) {
                ArrayHelper::setValue($linkOptions, 'tabindex', '-1');
                ArrayHelper::setValue($linkOptions, 'aria.disabled', 'true');
                Html::addCssClass($linkOptions, ['disable' => 'disabled']);
            } elseif ($active) {
                ArrayHelper::setValue($linkOptions, 'aria.current', 'true');
                Html::addCssClass($linkOptions, ['activate' => 'active']);
            }

            $url = array_key_exists('url', $item) ? $item['url'] : null;

            if ($url === null) {
                $headerContent = Html::tag('div', $label, ['class' => 'fw-semibold']);
                $content = Html::tag('div', $headerContent, ['class' => 'dropdown-header bg-light py-2']);
            } else {
                if (isset($item['iconClass'])) {
                    $iconClass = $item['iconClass'];
                } else {
                    $icon = $item['icon'] ?? static::$iconDefault;
                    $iconClass = 'icon ni ni-'.$icon;
                }
                $iconHtml = '<em class="'.$iconClass.'"></em>';
                $label = strtr($this->labelTemplate, [
                    '{icon}' => $iconHtml,
                    '{label}' => $label,
                    '{badge}' => isset($item['badge']) ? Html::tag('span', $item['badge'], ['class' => 'badge badge-primary ml-auto']) : '',
                ]);
                $content = Html::a($label, $url, $linkOptions);
            }
            $links[] = Html::tag('li', $content);
        }
        $links[] = Html::endTag('ul');

        $lines[] = Html::tag('div', implode("\n", $links), ['class' => 'dropdown-inner']);

        $lines[] = $this->renderSignout();

        return Html::tag('div', implode("\n", $lines), $options);
    }

    /**
     * Returns the user card with their info
     *
     * @return string
     */
    protected function renderUserInfo() : string
    {
        $userDivs = [];
        $userName = $this->findInitialLetters();
        $userDivs[] = Html::tag('div', Html::tag('span', $userName), ['class' => 'user-avatar']);

        $userData = [];
        $userData[] = Html::tag('span', $this->userFullName, ['class' => 'lead-text']);
        $userData[] = Html::tag('span', $this->userEmail, ['class' => 'sub-text']);
        $userDivs[] = Html::tag('div', implode("\n", $userData), ['class' => 'user-info']);

        $userCard = Html::tag('div', implode("\n", $userDivs), ['class' => 'user-card']);
        return Html::tag('div', $userCard, ['class' => 'dropdown-inner user-card-wrap bg-lighter d-none d-md-block']);
    }

    /**
     * Returns the first and second initial of the user full name in capital letters
     *
     * @return string
     */
    private function findInitialLetters() : string
    {
        $words = explode(" ", $this->userFullName);
        foreach ($words as $key => $word) {
            $words[$key] = strtoupper(mb_substr($word, 0, 1));
        }
        return mb_substr(implode("", $words), 0, 2);
    }

    /**
     * @return string
     */
    private function renderDarkSwitch() : string
    {
        $text = Html::tag('span', Yii::t('app', 'Dark Mode'));
        $link = Html::a('<em class="icon ni ni-moon"></em>'.$text, '#', ['class' => 'dark-switch']);
        return Html::tag('li', $link);
    }

    /**
     * Renders Signout form
     *
     * @return string
     */
    protected function renderSignout() : string
    {
        $signoutForm = Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex']);
        $span = Html::tag('span', Yii::t('app', 'Sign out'));
        $signoutForm .= Html::submitButton('<em class="icon ni ni-signout"></em>'.$span, ['class' => 'logout']);
        $signoutForm .= Html::endForm();
        $list = Html::tag('ul', Html::tag('li', $signoutForm), ['class' => 'link-list']);
        return Html::tag('div', $list, ['class' => 'dropdown-inner']);
    }
}