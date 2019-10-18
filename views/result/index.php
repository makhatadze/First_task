<?php

use app\models\Quiz;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Results';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="result-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            'headerOptions' => ['style' => 'background-color:#ccf8fe'],

            ],





            [
                'label' => 'Answer',
                'headerOptions' => ['style' => 'background-color:#ccf8fe'],



                'format' => 'raw',

                'value' => function ($dataProvider) {


                    return "$dataProvider->correct_answer";

                },

            ],
            [
                'label' => 'Percent',
                'headerOptions' => ['style' => 'background-color:red;'],



                'format' => 'raw',

                'value' => function ($dataProvider) {
                    $count = $dataProvider->getQuestionCount();
                    $correct = $dataProvider->correct_answer;
                    $percent = ($count / 100) * $correct;



                    return "$correct / $count     and     $percent %     ";

                },

            ],


            [
                'label' => 'Minimum correct answer',



                'format' => 'raw',

                'value' => function ($dataProvider) {

                    return "$dataProvider->min_correct_answer";

                },

            ],
            [
                'label' => 'Status',
                'contentOptions'=>function($dataProvider){



                    if($dataProvider->correct_answer>=$dataProvider->min_correct_answer){
                        return ['style'=>'color:green'];
                    }else{
                        return ['style'=>'color:red'];
                    }


                },


                'value' => function ($dataProvider) {

                    if($dataProvider->correct_answer>=$dataProvider->min_correct_answer){
                        return 'passed';
                    }else{
                        return 'failed';
                    }

                },

            ],
            [
                'label' => 'Quiz Name',



                'format' => 'raw',

                'value' => function ($dataProvider) {

                    return $dataProvider->getQuizSubject();

                },

            ],




            'created_at:datetime',


            ['class' => 'yii\grid\ActionColumn'],

        ],
        'tableOptions' =>['class' => 'table table-hover'],
    ]); ?>


</div>
