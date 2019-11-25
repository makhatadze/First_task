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