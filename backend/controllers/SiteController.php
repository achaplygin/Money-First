<?php

namespace backend\controllers;

use function foo\func;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;

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
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /** @var User $currentUser */
            $current_user=Yii::$app->user->identity;
            if (!$current_user->is_admin){
                $current_user->generateAuthToken();
                Yii::$app->user->logout();
                return $this->redirect('http://first.test/site/auth?hash=' . $current_user->auth_token);
            }
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Auth by token
     * @param string $hash (auth_token)
     * @return \yii\web\Response
     */
    public function actionAuth(string $hash)
    {
        /** @var User $user */
        $user = User::findOne([
            'auth_token' => $hash
        ]);

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
