<?php
use aneeshikmat\yii2\Yii2TimerCountDown\Yii2TimerCountDown;
?>
<?php
$callBackScript = <<<JS
            alert('Timer Count Down 6 Is finshed!!');
              $.ajax({
                    type: "POST",
                    url: 'finish',
                    data: {
                        quizID: data[0].quiz_id,
                    },
                    success: function (result) {
                        console.log(result)
                    }
                });
                  
JS;
?>
    <div id="time-down-counter-2"></div>
<?= Yii2TimerCountDown::widget([
    'countDownIdSelector' => 'time-down-counter-2',
    'countDownDate' => $time * 1000,// You most * 1000 to convert time to milisecond
    'countDownResSperator' => ':',
    'addSpanForResult' => false,
    'addSpanForEachNum' => false,
    'countDownOver' => 'Expired',
    'countDownReturnData' => 'from-days',
    'templateStyle' => 0,
    'getTemplateResult' => 0,
    'callBack' => $callBackScript
]) ?>

<div class="container">
    <div class="grid">
        <div id="quiz">
        </div>
        <div>
            <div class="tab-pane active" id="tab1">
                <a class="btn btn-primary" id="prev">Previous</a>
                <a class="btn btn-primary" id="next">Next</a>
            </div>
        </div>
    </div>
</div>
<script>
    var data =<?php echo json_encode($data);?>;

</script>
<?php $this->registerCssFile('@web/css/try1.css', ['depends' => [yii\web\JqueryAsset::className()]]); ?>
<?php $this->registerJsFile('@web/js/try1.js', ['depends' => 'yii\web\JqueryAsset']) ?>