<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Оформление заказа';
?>

<div class="order-create">
    <h2>Оформление заказа</h2>

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->id_product): ?>
        <?php
        $product = \app\models\Product::findOne($model->id_product);
        ?>
        <div class="alert alert-info">
            Товар: <strong><?= Html::encode($product ? $product->name_product : '—') ?></strong><br>
            Цена: <strong><?= $model->total_amount ?> ₽</strong>
        </div>
        <?= $form->field($model, 'id_product')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'total_amount')->hiddenInput()->label(false) ?>
    <?php else: ?>
        <?= $form->field($model, 'id_product')->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Product::find()->all(), 'id_product', 'name_product'),
            ['prompt' => 'Выберите товар']
        ) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>