<?php

namespace app\controllers;

use app\models\forms\ContactForm;
use app\models\forms\ResetPasswordForm;
use app\models\UserModel;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;
use yii2mod\rbac\components\AccessControl;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * Child classes may override this method to specify the behaviors they want to behave as.
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
     * Declares external actions for the controller.
     * @return array
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
            'login' => [
                'class' => 'yii2mod\user\actions\LoginAction'
            ],
            'logout' => [
                'class' => 'yii2mod\user\actions\LogoutAction'
            ],
            'signup' => [
                'class' => 'yii2mod\user\actions\SignupAction'
            ],
            'request-password-reset' => [
                'class' => 'yii2mod\user\actions\RequestPasswordResetAction'
            ],
            'password-reset' => [
                'class' => 'yii2mod\user\actions\PasswordResetAction'
            ],
            'page' => [
                'class' => 'yii2mod\cms\actions\PageAction',
            ],
        ];
    }

    /**
     * Index action
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Contact us action
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Account action
     */
    public function actionAccount()
    {
        /* @var $userModel UserModel */
        $userModel = Yii::$app->user->identity;
        $resetPasswordForm = new ResetPasswordForm($userModel);
        if ($resetPasswordForm->load(Yii::$app->request->post()) && $resetPasswordForm->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Password has been updated.'));
            return $this->refresh();
        }
        return $this->render('account', [
            'resetPasswordForm' => $resetPasswordForm,
            'userModel' => $userModel
        ]);
    }

}
