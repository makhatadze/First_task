<?php

namespace app\controllers;

use app\models\answer\Answer;
use app\models\answer\AnswerSearch;
use app\models\questions\Questions;
use app\models\questions\QuestionsSearch;
use Yii;
use app\models\Quiz;
use app\models\QuizSearch;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TestController implements the CRUD actions for Quiz model.
 */
class TestController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Quiz models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuizSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Quiz model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $searchModel = new QuestionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider -> query->where(['quiz_id'=>$id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Quiz model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Quiz();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Quiz model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Quiz model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Quiz::delQuestion($id);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Quiz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quiz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quiz::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStart($id)
    {

        if(Yii::$app->request->post()){

            var_dump($this);
        }




        $query = Questions::find()->where(['in','quiz_id',$id]);
        $model = new Answer();


        $an = Answer::find();
        $pagination = new Pagination([
            'defaultPageSize' =>11
            ,
            'totalCount' => $query->count(),
        ]);

        $questions = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $answer = $an->orderBy('name')
            ->all();


        return $this->render('start', [
            'questions' => $questions,
            'pagination' => $pagination,
            'answer' => $answer,
            'model' => $model,
        ]);

    }
    public function actionTest($id)
    {


        $min_correct = ArrayHelper::map(Quiz::find()->where(['in','id',$id])->all(),'id','min_corect_answer');

        $questions = Questions::find()->where(['in','quiz_id',$id])->all();
        $answers = Answer::find()->all();
        if(Yii::$app->request->post()){

            $correct = Yii::$app->request->post();
            $k = 0;

            foreach ($correct as $key=> $item) {

                if($correct[$key]==1){
                    $k+= 1;
                }

            }

            if ($min_correct[$id]<=$k) {
                Yii::$app->session->setFlash('success', "You successfully passed exam!");
            } else {
                Yii::$app->session->setFlash('error', "You failed! your correct answer is " .$k."! Min correct answer is  " .$min_correct[$id]);
            }
            return $this->redirect(['tr' ]);



        }

        return $this->render('test', [
            'questions' =>$questions,
            'answers'=>$answers,
    ]);

    }
    public function actionTr(){


        return $this->render('tr');
    }


}
