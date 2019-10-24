<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
?>
<?php


$form = ActiveForm::begin();
foreach ($settings as $setting) {
   /* echo $form->field($setting, "[$setting->id]value")->label($setting->name);*/

    echo $form->field($model, "[$setting->id]value")->label($setting->name);


}
echo Html::submitButton('Finish', ['class' => 'btn btn-info',
    'data' => [
        'confirm' => 'Are you sure that you want to finish test?',
        'method' => 'post'
    ],

]);
ActiveForm::end();


/*echo $form->radioButton($model, 'name', array(
    'value'=>1,
    'uncheckValue'=>null
));

echo $form->radioButton($model, 'name', array(
    'value'=>2,
    'uncheckValue'=>null
));
*/
