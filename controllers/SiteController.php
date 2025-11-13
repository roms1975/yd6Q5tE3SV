<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Post;
use app\models\PostSearch;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Post();
        $query = Post::find();
        $statistic = PostSearch::postStatisic();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['perPage'],
            ],
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $model->ip = Yii::$app->request->userIP ?: '';
            if ($model->save()) {
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось сохранить запись');
                return $this->render('index', ['model' => $model, 'dataProvider' => $dataProvider, 'statistic' => $statistic]);
            }
        }

        return $this->render('index', ['model' => $model, 'dataProvider' => $dataProvider, 'statistic' => $statistic]);
    }

}
