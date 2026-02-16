<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Заказ #' . $model->id_order;
?>
<div class="lk-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card mb-3">
        <div class="card-body">
            <?php if ($model->product_photo): ?>
                <img src="<?= Yii::getAlias('@web') . '/' . $model->product_photo ?>" 
                     class="img-fluid mb-3" 
                     style="max-width: 300px; height: auto;"
                     alt="<?= $model->product_name ?>">
            <?php endif; ?>

            <h4><?= Html::encode($model->product_name) ?></h4>
            <p><strong>Сумма:</strong> <?= $model->total_amount ?> ₽</p>
            <p><strong>Статус:</strong> <?= Html::encode($model->status_order) ?></p>
            <p><strong>Дата:</strong> <?= Yii::$app->formatter->asDatetime($model->timestamp_order) ?></p>
        </div>
    </div>

    <p>
        <?= Html::a('Назад', ['index'], ['class' => 'btn btn-secondary']) ?>
    </p>
</div>  