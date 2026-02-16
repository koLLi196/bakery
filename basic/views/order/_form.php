<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->dropDownList(
    \yii\helpers\ArrayHelper::map(\app\models\User::find()->all(), 'id_user', 'fio_user'),
    ['prompt' => 'Выберите пользователя']
) ?>

<?= $form->field($model, 'id_product')->dropDownList(
    \yii\helpers\ArrayHelper::map(\app\models\Product::find()->all(), 'id_product', 'name_product'),
    ['prompt' => 'Выберите товар']
) ?>

<?= $form->field($model, 'status_order')->dropDownList([
    'Новый' => 'Новый',
    'Готовится' => 'Готовится',
    'Готов' => 'Готов'
]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>