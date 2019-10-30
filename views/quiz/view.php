<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Quiz */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Quizzes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="quiz-view">

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
</div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'subject',
            'min_corect_answer',
            'created_at:datetime',
            'update_at:datetime',
            'max_question',
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
            [
                'label' => 'Certificate time',

                'format' => 'raw',

                'value' => function ($model) {
                    return "$model->certificate_valid_time Month";
                },

            ],
        ],
    ]) ?>

<h2>Questions</h2>
<?= Html::a('create new question', ['questions/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn',

        ],
        ['attribute' => 'Question',
            'value' => function ($model) {
                return $model->name;

            }
        ],
        ['class' => 'app\widgets\GridAction',
            'header' => 'Actions',
            'headerOptions' => ['style' => 'color:#337ab7'],
            'template' => '{view}{update}{delete}',
            'urlCreator' => function ($action, $model) {
                return "/questions/$action?id=" . $model->id;

            }
        ],
    ],
]); ?>



