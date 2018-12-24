<?php

use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\helpers\Html;

?>
<h3>Order create</h3>
<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'order-create']); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
            'mask' => '999-999-9999',
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
