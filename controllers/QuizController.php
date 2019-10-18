<?php

namespace app\controllers;

use app\models\answer\Answer;
use app\models\answer\AnswerSearch;
use app\models\questions\Questions;
use app\models\questions\QuestionsSearch;
use app\models\Result;
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
class QuizController extends Controller
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


    public function actionTest($id)
    {
        $result = new Result();


        $min_correct = ArrayHelper::map(Quiz::find()->where(['in','id',$id])->all(),'id','min_corect_answer');
        $quiz_name = ArrayHelper::map(Quiz::find()->where(['in','id',$id])->all(),'id','subject');

        $questions = Questions::find()->where(['in','quiz_id',$id])->all();
        if(Yii::$app->request->post()){

            $correct = Yii::$app->request->post();
            $k = 0;

            foreach ($correct as $key=> $item) {

                if($correct[$key]==1){
                    $k+= 1;
                }

            }
            $result->quiz_id = $id;
            $result->correct_answer= $k;
            $result->min_correct_answer =$min_correct[$id];
            $result->save();




            if ($min_correct[$id]<=$k) {
                Yii::$app->session->setFlash('success', "You successfully passed exam! Your correct answer is " .$k);
            } else {
                Yii::$app->session->setFlash('error', "You failed! your correct answer is " .$k."! Min correct answer is  " .$min_correct[$id]);
            }
            return $this->redirect(['tr' ]);

        }

        return $this->render('test', [
            'questions' =>$questions,
    ]);

    }
    public function actionTr(){


        return $this->render('tr');
    }


}
