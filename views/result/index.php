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
                'contentOptions'=>function ($dataProvider){

                    if($dataProvider->correct_answer>=$dataProvider->min_correct_answer){
                        return ['style'=>'background-color:MediumSeaGreen'];
                    }else{
                        return ['style'=>'background-color:Tomato'];
                    }


                },

                'value' => function () {
                    return '';
                },

            ],


            [
                'label' => 'Quiz Name',

                'format' => 'raw',

                'value' => function ($dataProvider) {
                    $s = $dataProvider->getQuizSubject();
                    if(!$s){
                        return '';
                    }else{
                        return $s;
                    }


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
                    $percent = ($count / 100) * $correct;
                    return \Yii::$app->formatter->asPercent($percent, 2);



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
                'label' => 'Passed Time',

                'format' => 'raw',

                'value' => function ($dataProvider) {

                    return Yii::$app->formatter->asDate($dataProvider->created_at);

                },

            ],

            ['class' => 'yii\grid\ActionColumn'],

        ],

    ]); ?>


</div>
