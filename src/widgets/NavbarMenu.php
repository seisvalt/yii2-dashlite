<?php
namespace andresbreads\dashlite\widgets;

use yii\helpers\ArrayHelper;
use yii\bootstrap5\Html;
use yii\helpers\Url;

/**
 * Widget that provides a navbar menu with the default options of user dropdown and notifications dropdown.
 * 
 * If any other menu items are going to be displayed before the default items, use the propery `$menu`.
 * 
 * @property array $options
 */
class NavbarMenu extends \yii\base\Widget
{
    /**
     * Menu items such as buttons or dropdowns that go before user and notifications options.
     * 
     * Receives string formatted tags to display the menu
     *
     * @var array
     */
    public $menu = [];

    public $userRole = 'Administrator';

    public $userFullName = 'John Doe';

    public $userEmail = 'info@softnio.com';

    public $userMenu = [];

    public $additionalUserInfo = null;

    /**
     * List of notifications.
     * 
     * Each item must contain
     * `['icon' => '<em class="icon icon-circle"></em>', 'text' => 'Notification', 'time' => '2 hrs ago']`
     *
     * @var array
     */
    public $notifications = [
        [
            'icon' => '<em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>',
            'text' => 'You have requested to <span>Widthdrawl</span>',
            'time' => '2 hrs ago',
        ],
        [
            'icon' => '<em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>',
            'text' => 'Your <span>Deposit Order</span> is placed',
            'time' => '2 hrs ago',
        ],
        [
            'icon' => '<em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>',
            'text' => 'You have requested to <span>Widthdrawl</span>',
            'time' => '2 hrs ago',
        ],
    ];

    /**
     * Tag to mark all notifications as read.
     * 
     * i.e. `<a href="#">Mark All as Read</a>`
     *
     * @var string
     */
    public $notificationsRead = '<a href="#">Mark All as Read</a>';

    /**
     * Url to view all the notifications
     *
     * @var string
     */
    public $notificationsUrl = '#';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (count($this->userMenu) == 0) {
            $this->userMenu = [
                ['label' => Yii::t('app', 'Messages'), 'url' => '/user/messages', 'icon' => 'emails', 'badge' => 42],
                ['label' => Yii::t('app', 'Tasks'), 'url' => '/user/tasks', 'icon' => 'task', 'badge' => 31],
                ['label' => Yii::t('app', 'Comments'), 'url' => '/user/comments', 'icon' => 'comments', 'badge' => 17],
                ['label' => Yii::t('app', 'View Profile'), 'url' => '/user/profile', 'icon' => 'user-alt'],
                ['label' => Yii::t('app', 'Account Setting'), 'url' => '/user/profile#setting', 'icon' => 'setting-alt'],
                ['label' => Yii::t('app', 'Login Activity'), 'url' => '/user/profile#activity', 'icon' => 'activity-alt'],
                'dark-switch',
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $items = $this->renderItems();
        return Html::tag('ul', $items, ['class' => 'nk-quick-nav']);
    }

    private function renderItems()
    {
        $items = "";
        foreach ($this->menu as $menu) {
            $items .= $menu;
        }
        $items .= $this->renderUserDropdown();
        $items .= $this->renderNotificationDropdown();
        return $items;
    }

    private function renderUserDropdown()
    {
        $icon = Html::tag('em', null, ['class' => 'icon ni ni-user-alt']);
        $icon = Html::tag('div', $icon, ['class' => 'user-avatar sm']);
        $infoRole = Html::tag('div', $this->userRole, ['class' => 'user-status']);
        $infoName = Html::tag('div', $this->userFullName, ['class' => 'user-name dropdown-indicator']);
        $userInfo = Html::tag('div', $infoRole . $infoName, ['class' => 'user-info d-none d-md-block']);
        $userInfo = Html::tag('div', $icon . $userInfo, ['class' => 'user-toggle']);
        $userInfo = Html::a($userInfo, '#', ['class' => 'dropdown-toggle', 'data-bs-toggle' => 'dropdown']);
        $userDropdown = UserDropdown::widget([
            'userRole' => $this->userRole,
            'userFullName' => $this->userFullName,
            'userEmail' => $this->userEmail,
            'items' => $this->userMenu,
            'additionalUserInfo' => $this->additionalUserInfo
        ]);
        return Html::tag('li', $userInfo . $userDropdown, ['class' => 'dropdown user-dropdown']);
    }

    private function renderNotificationDropdown()
    {
        $notificationIcon = Html::tag('em', null, ['class' => 'icon ni ni-bell']);
        $notificationIcon = Html::tag('div', $notificationIcon, ['class' => 'icon-status icon-status-info']);
        $notificationIcon = Html::a($notificationIcon, '#', ['class' => 'dropdown-toggle nk-quick-nav-icon', 'data-bs-toggle' => 'dropdown']);
        $notificationsHead = Html::beginTag('div', ['class' => 'dropdown-head']);
        $notificationsHead .= Html::tag('span', 'Notifications', ['class' => 'sub-title nk-dropdown-title']);
        $notificationsHead .= $this->notificationsRead;
        $notificationsHead .= Html::endTag('div');
        $notifications = $this->renderNotifications();
        $notifications = Html::tag('div', $notifications, ['nk-notification']);
        $notificationsBody = Html::tag('div', $notifications, ['class' => 'dropdown-body']);
        $notificationsFoot = Html::a('View All', $this->notificationsUrl);
        $notificationsFoot = Html::tag('div', $notificationsFoot, ['class' => 'dropdown-foot center']);
        $notificationDropdown = Html::beginTag('li', ['class' => 'dropdown notification-dropdown mr-n1']);
        $notificationDropdown .= $notificationIcon;
        $notificationDropdown .= Html::beginTag('div', ['class' => 'dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1']);
        $notificationDropdown .= $notificationsHead;
        $notificationDropdown .= $notificationsBody;
        $notificationDropdown .= $notificationsFoot;
        $notificationDropdown .= Html::endTag('div');
        $notificationDropdown .= Html::endTag('li');
        return $notificationDropdown;
    }

    private function renderNotifications()
    {
        $this->notifications;
        $notificationList = "";
        foreach ($this->notifications as $notification) {
            $icon = Html::tag('div', $notification['icon'], ['class' => 'nk-notification-icon']);
            $text = Html::tag('div', $notification['text'], ['class' => 'nk-notification-text']);
            $time = Html::tag('div', $notification['time'], ['class' => 'nk-notification-time']);
            $content = Html::tag('div', $text . $time, ['class' => 'nk-notification-content']);
            $notificationList .= Html::tag('div', $icon . $content, ['class' => 'nk-notification-item dropdown-inner']);
        }
        return $notificationList;
    }
}
