<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Result */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="result-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'quiz_id',
            'correct_answer',
            'min_correct_answer',
            'created_at',
            [
                'label' => 'Created By',

                'format' => 'raw',

                'value' => function ($model) {
                    $user = $model->getCreatedBy();
                    if(!$user){
                        return '';
                    }else{
                        return $user;
                    }
                },

            ],
            'updated_at',
            [
                'label' => 'Updated By',

                'format' => 'raw',

                'value' => function ($model) {
                    $user = $model->getUpdatedBy();
                    if(!$user){
                        return '';
                    }else{
                        return $user;
                    }
                },

            ],
        ],
    ]) ?>

</div>
