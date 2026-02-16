<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user app\models\User */

$this->title = 'Личный кабинет';
?>

<div class="lk-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <h2>История заказов</h2>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id_order',
           [
                'attribute' => 'product_name',
                'label' => 'Товар',
                'value' => function ($model) {
                    $name = $model->product_name ?: 'Товар';
                    return $name . ' — ' . $model->total_amount . ' ₽';
                },
            ],
            'status_order',
            'timestamp_order:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return \yii\helpers\Url::to(['/order/view', 'id_order' => $model->id_order]);
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>