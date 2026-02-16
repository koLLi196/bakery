<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passwordConfirm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agree')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
