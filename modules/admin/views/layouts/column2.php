<?php
use app\assets\AdminAsset;
use kartik\alert\AlertBlock;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */
AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags() ?>
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php echo AlertBlock::widget([
    'type' => AlertBlock::TYPE_GROWL,
    'useSessionFlash' => true
]);
?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Admin Panel',
        'brandUrl' => '/admin',
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
        'items' => [
            [
                'label' => '<i class="glyphicon glyphicon-user"></i> Users',
                'items' => [
                    [
                        'label' => '<i class="glyphicon glyphicon-th-list"></i> User List',
                        'url' => ['/admin/user/index'],
                    ],
                    [
                        'label' => '<i class="glyphicon glyphicon-plus"></i> Create User',
                        'url' => ['/admin/user/create'],
                    ]
                ]
            ],

            [
                'label' => '<i class="glyphicon glyphicon-cog"></i> Settings',
                'items' => [
                    [
                        'label' => '<i class="fa fa-pencil-square-o"></i> CMS',
                        'url' => ['/admin/cms/index'],
                    ],
                    [
                        'label' => '<i class="fa fa-repeat"></i> Clear Cache',
                        'url' => ['/admin/setting/clear-cache'],
                    ]
                ]
            ],

        ],
    ]);
    if (!Yii::$app->user->isGuest) {
        $menuItems = [
            ['label' => '<i class="glyphicon glyphicon-globe"></i> Public Area', 'url' => ['/']],
            ['label' => '<i class="glyphicon glyphicon-off"></i> Logout (' . Yii::$app->user->identity->username . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post'],
            ]
        ];

    } else {
        $menuItems = [];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?php echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php echo $content; ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
