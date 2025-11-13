<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Post;
use app\models\PostLinks;
use app\models\PostSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

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
        $query = Post::find()->where(['active' => 1]);
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
                $postLinks = new PostLinks();
                $postLinks->id = $model->id;
                $postLinks->token = Yii::$app->security->generateRandomString();
                $postLinks->save();
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось сохранить запись');
                return $this->render('index', ['model' => $model, 'dataProvider' => $dataProvider, 'statistic' => $statistic]);
            }
        }

        return $this->render('index', ['model' => $model, 'dataProvider' => $dataProvider, 'statistic' => $statistic]);
    }

    public function actionUpdatePost($token)
    {
        $link = PostLinks::find()->where(['token' => $token])->one();
        if ($link && $link->id0->active == 1) {
            if ($link->id0->load(Yii::$app->request->post())) {
                $link->id0->save();
                $this->redirect(['site/index']);
            }
            return $this->render('update', ['model' => $link->id0]);
        }

        throw new NotFoundHttpException('Страница не найдена');
    }

    public function actionDeletePost($token)
    {
        $link = PostLinks::find()->where(['token' => $token])->one();
        if ($link && $link->id0->active == 1) {
            if ($link->id0->load(Yii::$app->request->post())) {
                $link->id0->active = 0;
                if (!$link->id0->save()) 
                    error_log(print_r($link->id0->errors, true), 3, "/var/www/html/runtime/logs/post.log");

                $this->redirect(['site/index']);
            }
            return $this->render('delete', ['model' => $link->id0]);
        }

        throw new NotFoundHttpException('Страница не найдена');
    }
}
