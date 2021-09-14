<?php

namespace app\controllers;

use app\models\frontend\SignupForm;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\frontend\LoginForm;
use app\models\backend\User;

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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     * @var $user User
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post())) {
            $user = User::findOne(['username' => $model->username]);
            if(isset($user)){
                if ($user->validatePassword($model->password, $user->password)) {
                    $model->login($user);
                    $this->setSession($user);
                    return $this->goBack();
                }
                else{
                    $message = "Vous n'avez pas entré le bon mot de passe";
                    return $this->render('login', ['model' => $model, 'message' => $message]);
                }
            }
            else{
                $message = "L'utilisateur n'existe pas";
                return $this->render('login', ['model' => $model, 'message' => $message]);
            }
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;
        $session->destroy();
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup(){
        $model = new SignupForm();
        $message = null;

        if($model->load(Yii::$app->request->post()) && ['model' => $model]){
            if(User::findOne(['username'=> $model->username])){
                $message = "Ce nom d'utilisateur existe déjà";
                return $this->render('signup', ['model' => $model, 'message' => $message]);
            }
            else {
                \Yii::$app->db->createCommand()->insert('user', [
                    'username' => $model->username,
                    'password' => \Yii::$app->getSecurity()->generatePasswordHash($model->password),
                    'image' => ''
                ])->execute();
                return $this->goHome();
            }
        }
        else
            return $this->render('signup', ['model' => $model, 'message' => $message]);
    }

    private function setSession($user){
        $session = Yii::$app->session;
        $session->open();
        $session->set('username', $user->username);
        $session->set('userHealth', $user->health);
        $session->set('userStrength', $user->strength);
        $session->set('userDefense', $user->defense);
        $session->set('progression', 0);
        $session->set('spell', true);
        $session->set('monster', true);
        $session->set('door1', true);
        $session->set('door2', true);
    }

    public function actionMigrateUp()
    {
        // https://github.com/yiisoft/yii2/issues/1764#issuecomment-42436905
        $oldApp = \Yii::$app;
        new \yii\console\Application([
            'id'            => 'Command runner',
            'basePath'      => '@app',
            'components'    => [
                'db' => $oldApp->db,
                'authManager' => [
                    'class' => 'yii\rbac\DbManager',
                ],
            ],
        ]);
        \Yii::$app->runAction('migrate/up', ['migrationPath' => '@yii/rbac/migrations', 'interactive' => false]);
        \Yii::$app->runAction('migrate/up', ['interactive' => false]);
        \Yii::$app = $oldApp;
    }
}
