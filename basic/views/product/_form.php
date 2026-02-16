<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_product')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_category')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(), 'id_category', 'name_category'),
        ['prompt' => 'Выберите категорию']
    ) ?>

    <?= $form->field($model, 'photo_product_file')->fileInput() ?>
    
    <?= $form->field($model, 'price_product')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
