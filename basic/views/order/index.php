<?php


use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Order;
    use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id_order',
        'id_user',
        'timestamp_order:datetime',

        [
            'attribute' => 'status_order',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->getStatusBadge();
            },
            'filter' => [
                'Новый' => 'Новый',
                'Готовится' => 'Готовится',
                'Готов' => 'Готов',
            ],
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {start} {ready} {delivered}',
            'buttons' => [
                'start' => function ($url, $model) {
                    if ($model->status_order === 'Новый') {
                        return Html::a('Принять', 
                            ['start-processing', 'id' => $model->id_order],
                            ['class' => 'btn btn-sm btn-primary']
                        );
                    }
                    return '';
                },
                'ready' => function ($url, $model) {
                    if ($model->status_order === 'Готовится') {
                        return Html::a('Готов', 
                            ['mark-as-ready', 'id' => $model->id_order],
                            ['class' => 'btn btn-sm btn-success']
                        );
                    }
                    return '';
                },
                'delivered' => function ($url, $model) {
                    if ($model->status_order === 'Готов') {
                        return Html::a('Выдан', 
                            ['mark-as-delivered', 'id' => $model->id_order],
                            ['class' => 'btn btn-sm btn-secondary']
                        );
                    }
                    return '';
                },
            ],
        ],
    ],
]); ?>


</div>
