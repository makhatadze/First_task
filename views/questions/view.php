<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\questions\Questions */
/* @var $searchModel app\models\answer\AnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;

$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="questions-view">

    <h1><?= Html::encode('name') ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Create Answer', ['answer/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'hint',
            'max_answers',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model){
        if($model->is_correct==0){
            return ['class' => 'danger'];
        }elseif($model->is_correct==1){
            return ['class','success'];
        }
        },

        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
           

            ],

           [   'attribute' => 'Answers',
               'value' => function($model){
                return $model->name;





               }




            ],









            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
          'headerOptions' => ['style' => 'color:#337ab7'],
          'template' => '{status}{view}{update}{delete}',
          'buttons' => [

      /*        'status' => function($url, $model){
                if($model->is_correct==1){
                     $title = 'true';
                     $class = 'btn btn-circle btn-success';
                     $icon  = 'lock';
                     $status= '3';
                }
                else if($model->is_correct==0){
                    $title = 'false';
                    $class = 'btn btn-circle btn-danger';
                    $icon  = 'lock-open';
                    $status= '1';
                }



                $options = [
                    //'id' => 'sa-params',
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                    'class' => $class,
                ];
                $icon = Html::tag('i', '', ['class' => "fa fa-$icon"]);
                return Html::button($icon, $options);
            },*/







            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'lead-view'),

                ]);
            },

            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'lead-update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('app', 'lead-delete'),
                ]);
            }

          ],
          'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='http://app.test/answer/view?id='.$model->id;
                return $url;
            }

            if ($action === 'update') {
                $url ='http://app.test/answer/update?id='.$model->id;
                return $url;
            }
            if ($action === 'delete') {
                $url ='http://app.test/answer/delete?id='.$model->id;
                return $url;
                }
            }














            ],
        ],
    ]); ?>



</div>
