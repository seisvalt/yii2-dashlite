<?php

use andresbreads\dashlite\widgets\Menu;
use andresbreads\dashlite\widgets\UserDropdown;
use andresbreads\dashlite\assets\DashLiteAsset;
use andresbreads\dashlite\assets\SimplebarAsset;

DashLiteAsset::register($this);
SimplebarAsset::register($this);

list(,$url) = Yii::$app->assetManager->publish('@andresbreads/dashlite/assets');

$this->params['logo'] = $this->params['logo'] ?? $url.'/images/logo.png';
$this->params['logo2x'] = $this->params['logo2x'] ?? $url.'/images/logo2x.png';
$this->params['logoDark'] = $this->params['logoDark'] ?? $url.'/images/logo-dark.png';
$this->params['logoDark2x'] = $this->params['logoDark2x'] ?? $url.'/images/logo-dark2x.png';

$this->params['mainMenu'] = $this->params['mainMenu'] ?? [
    [
        'label' => 'Starter Pages',
        'icon' => 'meter',
        'badge' => '2',
        'items' => [
            ['label' => 'Active Page', 'url' => ['site/index']],
            ['label' => 'Inactive Page'],
        ]
    ],
    ['label' => 'Simple Link', 'icon' => 'list-index', 'badge' => 'New'],
    ['label' => 'Yii2 PROVIDED', 'header' => true],
    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'signin', 'visible' => Yii::$app->user->isGuest],
    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
    ['label' => 'Debug', 'icon' => 'bugs', 'url' => ['/debug'], 'target' => '_blank'],
    ['label' => 'MULTI LEVEL EXAMPLE', 'header' => true],
    ['label' => 'Level1'],
    [
        'label' => 'Level1',
        'items' => [
            ['label' => 'Level2'],
            [
                'label' => 'Level2',
                'items' => [
                    ['label' => 'Level3', 'icon' => 'circle-fill'],
                    ['label' => 'Level3', 'icon' => 'circle-fill'],
                    ['label' => 'Level3', 'icon' => 'circle-fill']
                ]
            ],
            ['label' => 'Level2']
        ]
    ],
    ['label' => 'Level1'],
    ['label' => 'LABELS', 'header' => true],
    ['label' => 'Important'],
    ['label' => 'Warning'],
    ['label' => 'Informational'],
];

$this->params['userRole'] = $this->params['userRole'] ?? 'Administrator';
$this->params['userFullName'] = $this->params['userFullName'] ?? 'Abu Bin Ishtiyak';
$this->params['userEmail'] = $this->params['userEmail'] ?? 'info@softnio.com';

$this->params['userMenu'] = $this->params['userMenu'] ?? [
    ['label' => Yii::t('app', 'Messages'), 'url' => '/user/messages', 'icon' => 'emails', 'badge' => 42],
    ['label' => Yii::t('app', 'Tasks'), 'url' => '/user/tasks', 'icon' => 'task', 'badge' => 31],
    ['label' => Yii::t('app', 'Comments'), 'url' => '/user/comments', 'icon' => 'comments', 'badge' => 17],
    ['label' => Yii::t('app', 'Messages'), 'url' => '/user/messages', 'icon' => 'emails', 'badge' => 42],
    ['label' => Yii::t('app', 'Settings')],
    ['label' => Yii::t('app', 'View Profile'), 'url' => '/user/profile', 'icon' => 'user-alt'],
    ['label' => Yii::t('app', 'Account Setting'), 'url' => '/user/profile#setting', 'icon' => 'setting-alt'],
    ['label' => Yii::t('app', 'Login Activity'), 'url' => '/user/profile#activity', 'icon' => 'activity-alt'],
    'dark-switch',
];
?>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-sidebar-brand">
                        <a href="<?= Yii::$app->homeUrl ?>" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="<?= $this->params['logo'] ?>" srcset="<?= $this->params['logo2x'] ?> 2x" alt="logo">
                            <img class="logo-dark logo-img" src="<?= $this->params['logoDark'] ?>" srcset="<?= $this->params['logoDark2x'] ?> 2x" alt="logo-dark">
                        </a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <?= Menu::widget(['items' => $this->params['mainMenu']]) ?>
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ml-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="<?= Yii::$app->homeUrl ?>" class="logo-link">
                                    <img class="logo-light logo-img" src="<?= $this->params['logo'] ?>" srcset="<?= $this->params['logo2x'] ?> 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="<?= $this->params['logoDark'] ?>" srcset="<?= $this->params['logoDark2x'] ?> 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                            <div class="nk-header-news d-none d-xl-block">
                                <div class="nk-news-list">
                                    <a class="nk-news-item" href="<?= Yii::$app->homeUrl ?>">
                                        <div class="nk-news-icon">
                                            <em class="icon ni ni-home"></em>
                                        </div>
                                    </a>
                                </div>
                            </div><!-- .nk-header-news -->
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info d-none d-md-block">
                                                    <div class="user-status">Administrator</div>
                                                    <div class="user-name dropdown-indicator">Abu Bin Ishityak</div>
                                                </div>
                                            </div>
                                        </a>
                                        <?= UserDropdown::widget([
                                            'userRole' => $this->params['userRole'],
                                            'userFullName' => $this->params['userFullName'],
                                            'userEmail' => $this->params['userEmail'],
                                            'items' => $this->params['userMenu'],
                                        ]) ?>
                                    </li><!-- .dropdown -->
                                    <li class="dropdown notification-dropdown mr-n1">
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1">
                                            <div class="dropdown-head">
                                                <span class="sub-title nk-dropdown-title">Notifications</span>
                                                <a href="#">Mark All as Read</a>
                                            </div>
                                            <div class="dropdown-body">
                                                <div class="nk-notification">
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                            <div class="nk-notification-time">2 hrs ago</div>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-notification -->
                                            </div><!-- .nk-dropdown-body -->
                                            <div class="dropdown-foot center">
                                                <a href="#">View All</a>
                                            </div>
                                        </div>
                                    </li><!-- .dropdown -->
                                </ul><!-- .nk-quick-nav -->
                            </div><!-- .nk-header-tools -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <?= $content ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- footer @s -->
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; 2020 DashLite. Template by <a href="https://softnio.com" target="_blank">Softnio</a>
                            </div>
                            <div class="nk-footer-links">
                                <ul class="nav nav-sm">
                                    <li class="nav-item"><a class="nav-link" href="#">Terms</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">Privacy</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
                                    <li class="nav-item dropup">
                                        <a class="dropdown-toggle dropdown-indicator has-indicator nav-link" data-toggle="dropdown" data-offset="0,10"><span>English</span></a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <ul class="language-list">
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="<?=$url?>/images/flags/english.png" alt="" class="language-flag">
                                                        <span class="language-name">English</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="<?=$url?>/images/flags/spanish.png" alt="" class="language-flag">
                                                        <span class="language-name">Español</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="<?=$url?>/images/flags/french.png" alt="" class="language-flag">
                                                        <span class="language-name">Français</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="language-item">
                                                        <img src="<?=$url?>/images/flags/turkey.png" alt="" class="language-flag">
                                                        <span class="language-name">Türkçe</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- Department -->
    <div class="modal fade" id="addData">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross-sm"></em>
                </a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Add Employee</h5>
                    <form action="#" class="mt-2">
                        <div class="row g-gs">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name"> Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="name" placeholder="Abu Bin Istiak">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="email"> Email</label>
                                    <div class="form-control-wrap">
                                        <input type="email" class="form-control" id="email" placeholder="info@softnio.com">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Department</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select">
                                            <option value="default_option">Select Department</option>
                                            <option value="bangladesh">Information Technology</option>
                                            <option value="canada">Finance</option>
                                            <option value="england">Marketing</option>
                                            <option value="pakistan">Human Resource</option>
                                            <option value="usa">Graphics</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="code">Designation</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="code" placeholder="Software developer">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="phone">Phone</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="phone" placeholder="+124 394-1787">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Address(Lane)</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select">
                                            <option value="default_option">Select Address</option>
                                            <option value="dhaka">House 165, Lane No 3, Mohakhali DOHS,Dhaka</option>
                                            <option value="london">199 Bishopsgate, London</option>
                                            <option value="mumbai">Narottam Morarji Marg, Mumbai</option>
                                            <option value="kualalampur">Ipoh, Johor Bahru, Kualalampur</option>
                                            <option value="spain">Gran Vía, Madrid.</option>
                                            <option value="usa">182/A Y-ra, Boston</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Varified</label>
                                    <div class="form-control-wrap">
                                        <ul class="custom-control-group g-3 align-center flex-wrap">
                                            <li>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" checked="" id="Check1">
                                                    <label class="custom-control-label" for="Check1">Email</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" checked="" id="Check2">
                                                    <label class="custom-control-label" for="Check2">KYC</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button data-dismiss="modal" type="submit" class="btn btn-primary">Add Employee</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- .Edit Modal-Content -->
    <div class="modal fade" id="editData">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross-sm"></em>
                </a>
                <div class="modal-body modal-body-md">
                    <h5 class="modal-title">Edit Employee</h5>
                    <form action="#" class="mt-2">
                        <div class="row g-gs">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="edit-name"> Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="edit-name" value="Abu Bin Istiak">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="edit-email"> Email</label>
                                    <div class="form-control-wrap">
                                        <input type="email" class="form-control" id="edit-email" value="info@softnio.com">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="dept">Department</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="dept">
                                            <option value="default_option">Select Department</option>
                                            <option value="bangladesh">Information Technology</option>
                                            <option value="canada">Finance</option>
                                            <option value="england">Marketing</option>
                                            <option value="pakistan">Human Resource</option>
                                            <option value="usa">Graphics</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="edit-code">Designation</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="edit-code" value="Software developer">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="edit-phone">Phone</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="edit-phone" value="+124 394-1787">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Address(Lane)</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select">
                                            <option value="default_option">Select Address</option>
                                            <option value="dhaka">House 165, Lane No 3, Mohakhali DOHS,Dhaka</option>
                                            <option value="london">199 Bishopsgate, London</option>
                                            <option value="mumbai">Narottam Morarji Marg, Mumbai</option>
                                            <option value="kualalampur">Ipoh, Johor Bahru, Kualalampur</option>
                                            <option value="spain">Gran Vía, Madrid.</option>
                                            <option value="usa">182/A Y-ra, Boston</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Varified</label>
                                    <div class="form-control-wrap">
                                        <ul class="custom-control-group g-3 align-center flex-wrap">
                                            <li>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" checked="" id="customCheck1">
                                                    <label class="custom-control-label" for="customCheck1">Email</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" checked="" id="customCheck2">
                                                    <label class="custom-control-label" for="customCheck2">KYC</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button data-dismiss="modal" type="submit" class="btn btn-primary">Update Employee</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- .Edit Modal-Content -->
    <div class="modal fade" id="deleteData">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross"></em></a>
                <div class="modal-body modal-body-sm text-center">
                    <div class="nk-modal py-4">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                        <h4 class="nk-modal-title">Are You Sure ?</h4>
                        <div class="nk-modal-text mt-n2">
                            <p class="text-soft">This item will be removed permanently.</p>
                        </div>
                        <ul class="d-flex justify-content-center gx-4 mt-4">
                            <li>
                                <button data-dismiss="modal" id="deleteEvent" class="btn btn-success">Yes, Delete it</button>
                            </li>
                            <li>
                                <button data-dismiss="modal" data-toggle="modal" data-target="#editEventPopup" class="btn btn-danger btn-dim">Cancel</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .Delete Modal-content -->
    <!-- Dashboard -->
    <div class="modal fade" id="editDataDash">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Information</h5>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="form-group">
                            <label class="form-label" for="dept-name">Dept. Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="dept-name" value="Finance">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="author-name">Author Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="author-name" value="Abu Bin Istiak">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="designtn">Designation</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="designtn" value="Admin">
                            </div>
                        </div>
                        <div class="form-group">
                            <button data-dismiss="modal" type="submit" class="btn btn-primary">Save Informations</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- .Edit Modal-Content -->
</body>