<?php

use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuizSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quizzes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quiz-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if (!Yii::$app->user->isGuest) {
            echo Html::a('Create Quiz', ['create'], ['class' => 'btn btn-success']);
        }

        ?>
    </p>


    <div id="message">
        <h1>
            <?= Yii::$app->session->getFlash('success'); ?>
        </h1>
    </div>
    <div id="message">
        <h1>
            <?= Yii::$app->session->getFlash('error'); ?>
        </h1>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Online Testing',
                'format' => 'raw',
                'visible' => !Yii::$app->user->isGuest,
                'value' => function ($dataProvider) {

                    return Html::a('Start test', ['test', 'id' => $dataProvider->id], [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Are you sure that you want to start test?',
                        ],
                    ]);
                },
            ],
            'subject',
            'min_corect_answer',
            [
                'attribute' => 'Created At',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asDate($dataProvider->created_at);
                },
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])
            ],
            [
                'attribute' => 'Updated At',
                'value' => function ($dataProvider) {
                    return Yii::$app->formatter->asDate($dataProvider->update_at);
                },

                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'update_at',
                    'clientOptions' => [
                        'autoclose' => true,

                    ]
                ])
            ],
            [
                'class' => 'app\widgets\GridAction',],
        ],
    ]); ?>
</div>
