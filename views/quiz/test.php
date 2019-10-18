<?php

use app\models\questions\Questions;
use app\models\Quiz;
use yii\helpers\ArrayHelper;
use app\models\answer\Answer;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;


?>

<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
<?php foreach ($questions as $question): ?>

    <div class="container">
        <div class="row">
            <br/>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?php echo $question->name ?>
                </div>

                <div class="panel-body">
                    <h4>Your Answer</h4>
                </div>
                <?php foreach ($question->answers as $answer): ?>
                    <div class="funkyradio-default">
                        <?php echo Html::radio("selectedAnswer_{$question->id}", false, [
                            'value' => $answer->is_correct
                        ]) ?>
                        <label for="<?php echo "selectedAnswer_{$question->id}" ?>">
                            <?php echo $answer->name ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="form-group">
    <?= Html::submitButton('Finish', ['class' => 'btn btn-info',
        'data' => [
            'confirm' => 'Are you sure that you want to finish test?',
            'method' => 'post'
        ],

    ]) ?>
</div>
<?php ActiveForm::end(); ?>





