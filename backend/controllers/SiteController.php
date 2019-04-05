<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use yii\filters\AccessControl;
use yii\helpers\BaseStringHelper;
use backend\models\AccountSearch;

/**
 * Site controller
 */
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
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'auth'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'matchCallback' => function () {
                            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->is_admin) {
                                return true;
                            }
                            return false;
                        },
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 10];
        $dataProvider->sort = [
            'attributes' => [
                'id',
                'user_id',
                'balance',
                'user.username',
                'user.email',
            ]];

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    /**
     * If user is not admin, logout and redirect to user section with authentication by token.
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /** @var User $current_user */
            $current_user = Yii::$app->user->identity;
            if (!$current_user->is_admin) {
                $current_user->generateAuthToken();
                Yii::$app->user->logout();
                $domain = BaseStringHelper::byteSubstr($_SERVER['SERVER_NAME'], 6);
                return $this->redirect('http://'.$domain.'/site/auth?hash=' . $current_user->auth_token);
            }
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render(
                'login', [
                'model' => $model,
                ]
            );
        }
    }

    /**
     * Auth by token
     *
     * @param  string $hash (auth_token)
     * @return \yii\web\Response
     */
    public function actionAuth(string $hash)
    {
        /** @var User $user */
        $user = User::findOne(
            [
            'auth_token' => $hash
            ]
        );

        if (($user !== null) && $user->is_admin) {
            Yii::$app->user->login($user);
            $user->removeAuthToken();
        }

        return $this->redirect('/');
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
