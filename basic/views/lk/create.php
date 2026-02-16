<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Product;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Оформление заказа';
?>

<div class="lk-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'id_product')->dropDownList(
        ArrayHelper::map(Product::find()->all(), 'id_product', function ($product) {
            $img = $product->photo_product 
                ? '<img src="' . Yii::getAlias('@web') . '/' . $product->photo_product . '" width="30" style="vertical-align: middle; margin-right: 5px;">'
                : '';
            return $img . $product->name_product . ' (' . $product->price_product . ' ₽)';
        }),
        ['prompt' => 'Выберите товар']
    ) ?>

    <?= $form->field($model, 'status_order')->hiddenInput(['value' => 'Новый'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>