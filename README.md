Yii2 DashLite
===============


Yii2 extension for DashLite dashboard

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).


```
php composer.phar require --prefer-dist andres-breads/yii2-dashlite "*"
```

or add

```
"andres-breads/yii2-dashlite": "dev"
```

to the require section of your `composer.json` file.


Usage
-----

Make your `@app/views/layouts/main.php` to look like:

```html

<?php $this->beginContent('@andresbreads/dashlite/layouts/main.php') ?>
    <?= $content ?>
<?php $this->endContent() ?>

```

If you want to customize the menus, footer and user thumbnail,
these are the params used inside the layout to overwrite them:

```php

$this->params['mainMenu']; // Receives a list to be used in Menu::widget()
$this->params['topLeftMenu']; // Receives a list to be used in Nav::widget()
$this->params['topRightMenu']; // Receives a list to be used in Nav::widget()
$this->params['userThumbnail']; // Receives a string to be used in <img src>
$this->params['userMenu']; // Receives a list to be used in Dropdown::widget()
$this->params['leftFooter']; // Receives a string
$this->params['rightFooter']; // Receives a string

```