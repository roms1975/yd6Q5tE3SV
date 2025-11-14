<?php

namespace app\controllers;

use Yii;
use yii\base\BaseObject;
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
        $model->setScenario(POST::SCENARIO_CREATE);

        $query = Post::find()->where(['active' => 1])->orderBy('created DESC');
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
                $token = Yii::$app->security->generateRandomString();
                $postLinks->token = preg_replace('/[^a-zA-Z0-9]/', '', $token);

                $postLinks->save();

                /* сохраняем ссылки для обновления и удаления поста */
                $url = Yii::$app->request->hostInfo;
                error_log("Ссылка для редактирования поста ID={$postLinks->id}: " .
                    "{$url}/site/update-post/{$postLinks->token}\n", 3, "/var/www/html/runtime/logs/links.log");

                error_log("Ссылка для удаления поста ID={$postLinks->id}: " .
                    "{$url}/site/delete-post/{$postLinks->token}\n", 3, "/var/www/html/runtime/logs/links.log");

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
        $model = $link->id0;
        if (($link !== null) && $model->active == 1) {
            if ($model->load(Yii::$app->request->post())) {
                $model->setScenario(POST::SCENARIO_UPDATE);
                if ($model->save()) {
                    $this->redirect(['site/index']);
                }

                Yii::$app->session->setFlash('error', 'Не удалось обновить запись');
            }

            return $this->render('update', ['model' => $model]);
        }

        throw new NotFoundHttpException('Страница не найдена');
    }

    public function actionDeleteConfirm($token)
    {
        $link = PostLinks::find()->where(['token' => $token])->one();
        if (($link === null) || $link->id0->active == 0) {
            throw new NotFoundHttpException('Запись не найдена.');
        }

        return $this->render('delete', ['model' => $link->id0, 'token' => $link->token]);
    }

    public function actionDeletePost($token)
    {
        $link = PostLinks::find()->where(['token' => $token])->one();
        if (($link !== null) && $link->id0->active == 1) {
            $model = $link->id0;
            $model->setScenario(POST::SCENARIO_DELETE);

            if ($model->load(Yii::$app->request->post())) {
                $model->active = 0;
                if ($model->save()) {
                    $this->redirect(['site/index']);
                }

                Yii::$app->session->setFlash('error', 'Не удалось удалить запись');
            }

            return $this->render('delete', ['model' => $model, 'token' => $link->token]);
        }

        throw new NotFoundHttpException('Запись не найдена');
    }
}
