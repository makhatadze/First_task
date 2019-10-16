<?php

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
            <?= Html::a('Create Quiz', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,

            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                [
                    'label' => 'Subject',
                    'format' => 'raw',
                    // here comes the problem - instead of parent_region I need to have parent
                    'value' => function ($dataProvider) {
                        return Html::a('Start test', ['test','id'=>$dataProvider->id],[
                                'class' =>'btn btn-info',
                            'data' =>[
                              'confirm' => 'Are you sure you want to start test?',

                            ],

                        ]);
                    },
                ],
                'subject',

                'min_corect_answer',
                'created_at:datetime',
                'update_at:datetime',

                //'max-question',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
