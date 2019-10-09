<?php

use app\models\questions\Questions;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\answer\Answer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answer-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model,'question_id')
        ->dropDownList(
            ArrayHelper::map(Questions::find()->all(),'id','name')
        )
    ?>

    <?= $form->field($model, 'is_correct')->checkBox(['label' => 'active', 'selected' => $model->is_correct]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
