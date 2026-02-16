<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Оформление заказа';
?>
<div class="order-order">

    <h2>Оформление заказа</h2>

    <?php if ($product): ?>
        <div class="alert alert-info">
            <strong><?= Html::encode($product->name_product) ?></strong><br>
            Цена: <?= $product->price_product ?> ₽
        </div>
        <?= Html::hiddenInput('Order[id_product]', $product->id_product) ?>
        <?= Html::hiddenInput('Order[total_amount]', $product->price_product) ?>
    <?php else: ?>
        <?= $form->field($model, 'id_product')->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Product::find()->all(), 'id_product', 'name_product'),
            ['prompt' => 'Выберите товар']
        ) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary']) ?>
    </div>

</div>