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
        'layout' => '{items}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Status',
                'contentOptions' => function ($dataProvider) {

                    if ($dataProvider->correct_answer >= $dataProvider->min_correct_answer) {
                        return ['style' => 'background-color:hover;
                        color: green;
                        '];
                    } else {
                        return ['style' => 'background-color:hover;
                        color: red;
                        
                        text-style: bold;
                        
                  
                        
                        '];
                    }


                },

                'value' => function ($dataProvider) {
                    if ($dataProvider->correct_answer >= $dataProvider->min_correct_answer) {
                        return 'passed';
                    } else {
                        return 'failed';
                    }
                },

            ],
            [
                'label' => 'Student',

                'format' => 'raw',

                'value' => function ($dataProvider) {
                    return $dataProvider->getUserName();
                },

            ],


            [
                'label' => 'Quiz Name',

                'format' => 'raw',

                'value' => function ($dataProvider) {
                    if (!$dataProvider->quiz_name) {
                        return '';
                    }
                    return $dataProvider->quiz_name;

                },

            ],


            [
                'label' => 'Correct Answer',


                'format' => 'raw',

                'value' => function ($dataProvider) {

                    return "$dataProvider->correct_answer";
                },
            ],

            [
                'label' => 'Percent',

                'format' => 'raw',
                'value' => function ($dataProvider) {
                    $count = $dataProvider->question_count;
                    $correct = $dataProvider->correct_answer;
                    if ($count != 0) {

                        $percent = $correct / $count;

                        return \Yii::$app->formatter->asPercent($percent, 0);
                    }
                    return '0%';
                },

            ],


            [
                'label' => 'Min-correct answer',

                'format' => 'raw',

                'value' => function ($dataProvider) {

                    return "$dataProvider->min_correct_answer";

                },

            ],


            [
                'label' => 'Passed Time',

                'format' => 'raw',

                'value' => function ($dataProvider) {

                    return Yii::$app->formatter->asDate($dataProvider->created_at);

                },

            ],
            [
                'label' => 'Certificate status',
                'contentOptions' => function ($dataProvider) {

                    if ($dataProvider->certificate_valid_time > time()) {
                        return ['style' => 'background-color:hover;
                        color: green;
                        '];
                    } else {
                        return ['style' => 'background-color:hover;
                        color: red;
                        
                        text-style: bold;
                                          
                        '];
                    }

                },

                'format' => 'raw',

                'value' => function ($dataProvider) {
                    $validTime = Yii::$app->formatter->asDate($dataProvider->certificate_valid_time);

                    if ($dataProvider->certificate_valid_time > time()) {
                        return "Valid  ($validTime)";
                    } else if (!$validTime) {
                        return "Invalid ($validTime)";
                    } else {
                        return "Invalid";
                    }

                },

            ],


        ],

    ]); ?>


</div>
