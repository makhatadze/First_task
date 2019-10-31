
    <div id="message">

    <h1>
    <?= Yii::$app->session->getFlash('success');?>
    </h1>
</div>
<div id="message">
    <h1>
  <?= Yii::$app->session->getFlash('error');?>
    </h1>

</div>
