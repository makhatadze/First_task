<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\questions\Questions */
/* @var $searchModel app\models\answer\AnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="questions-view">

    <h1><?= Html::encode($model->name) ?></h1>

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
            'name',
            'hint',
            'max_answers',
            'created_at:datetime',
            [
                'label' => 'Created By',

                'format' => 'raw',

                'value' => function ($model) {
                    $user = $model->getCreatedBy();
                    if (!$user) {
                        return '';
                    } else {
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
                    if (!$user) {
                        return '';
                    } else {
                        return $user;
                    }
                },

            ],

        ],
    ]); ?>
    <h2>Answers</h2>
    <?= Html::a('Create new answer', ['answer/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'Answers',
                'value' => function ($model) {
                    return $model->name;
                }
            ],
            ['attribute' => 'Status',
                'value' => function ($model) {
                    if ($model->is_correct) {
                        return 'Correct';
                    }
                    return 'Incorrect';
                }
            ],
            ['class' => 'app\widgets\GridAction',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}{update}{delete}',

                'urlCreator' => function ($action, $model, $key, $index) {
                    return "/answer/$action?id=" . $model->id;
                }
            ],
        ],
    ]); ?>
</div>
