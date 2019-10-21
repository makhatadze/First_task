<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\answer\Answer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="answer-view">

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
        <?= Html::a('Create new answer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'is_correct',
            'name',
            'created_at:datetime',
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
            'updated_at:datetime',
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
