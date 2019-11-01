<?php

namespace app\controllers;

use app\models\questions\Questions;
use app\models\questions\QuestionsSearch;
use app\models\Quiz;
use app\models\QuizSearch;
use app\models\Result;
use Yii;
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

        $quiz = $this->findModel($id);

        if ($quiz->questionValidate() == false) {
            Yii::$app->session->setFlash('error', "Quiz have not question! ");
            return $this->redirect('index');
        } else if ($quiz->answerValidate($id) == false) {
            Yii::$app->session->setFlash('error', "Some question have not answer! ");
            return $this->redirect('index');
        }

        $result = new Result();
        $questions = Questions::find()->where(['in', 'quiz_id', $id])->all();
        if (Yii::$app->request->post()) {

            $result->createResult(Yii::$app->request->post(), $id, $result);

            if ($result->save()) {


                if ($result->certificate_valid_time) {
                    Yii::$app->session->setFlash('success', "You successfully passed exam! Your correct answer is " . $result->correct_answer);
                } else {
                    Yii::$app->session->setFlash('error', "You failed! your correct answer is " . $result->correct_answer . "! Min correct answer is  " . $result->min_correct_answer);
                }
                return $this->redirect(['result/index']);
            } else {
                echo($result->errors);
                exit();
            }

        }

        return $this->render('test', [
            'questions' => $questions,
        ]);

    }


}
