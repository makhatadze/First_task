<?php

namespace app\controllers;

use app\models\answer\Answer;
use app\models\LogAnswer;
use app\models\questions\Questions;
use app\models\questions\QuestionsSearch;
use app\models\Quiz;
use app\models\QuizSearch;
use app\models\Result;
use pollext\poll\Poll;
use Yii;
use yii\base\Action;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'index', 'update', 'test', 'view', 'delete'],
                'rules' => [
                    // deny all POST requests
                    [
                        'allow' => true,
                        'verbs' => ['POST']
                    ],
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
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
        $dataProvider->query->where(['quiz_id' => $id]);

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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                var_dump($model->errors);
                exit();
            }
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

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_by = Yii::$app->user->getId();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
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

        Quiz::deleteQuestion($id);
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
        $model = new LogAnswer();

        $model = $model->createLog($id);
        $quiz = $this->findModel($id);
        $quiz_time = $quiz->quiz_time;


        $time = LogAnswer::find()->where(['quiz_id' => $id, 'user_id' => Yii::$app->user->id])->sum('created_at');
        $time;
        $time -= 7200 - $quiz_time * 60;

        // Quiz validate
        $validationResult = $quiz->generalValidate($id);
        if (!$validationResult['success']) {
            Yii::$app->session->setFlash('error', $validationResult['message']);
            return $this->redirect('index');
        }
        $result = new Result();

        $data = $result->dataJsonEncode($id);

        return $this->render('test', [
            'data' => $data,
            'time' => $time,
        ]);
    }

    public function actionSave()
    {

        if (Yii::$app->request->isAjax) {
            $user_id = Yii::$app->user->id;
            $data = Yii::$app->request->post();
            $id = LogAnswer::find()->where(['question_id' => $data['questionId']])->select('question_id')->scalar();
            $int = (int)$id;
            $model = LogAnswer::find()->where(['question_id' => $int])->andWhere(['user_id' => $user_id])->one();
            if ($model) {
                $model->answer_id = $data['selected'];
                $model->save();

            } else {
                $model = new LogAnswer();
                $data = Yii::$app->request->post();
                $model->user_id = $user_id;
                $model->quiz_id = (int)$data['quizId'];
                $model->question_id = (int)$data['questionId'];
                $model->answer_id = (int)$data['selected'];
                if ($model->save()) {

                } else {
                    var_dump($model->errors);
                    exit();
                }
            }
        }
    }

    public function actionResult()
    {
        if (Yii::$app->request->isAjax) {
            $model = new Result();
            $data = Yii::$app->request->post();

            var_dump($model->createResult($data));
            exit();

        }
    }

    public function actionFinish()
    {

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $quizID = $data['quizID'];
            $model = new Result();

            if ($model->finishTime($quizID)) {

            }
            return $this->redirect('finish');
        }

        return $this->render('finish');

    }

}
