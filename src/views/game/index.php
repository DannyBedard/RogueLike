<?php
use yii\helpers\Html;
use \yii\widgets\ActiveForm;

/* @var $door1 app\models\core\Door */
/* @var $door2 app\models\core\Door */

$session = Yii::$app->session;
$session->open();

$this->title = 'Jeu';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title)?></h1>
<p>Veuillez choisir une porte</p>

<? $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton("Porte 1", ['class' => 'btn btn-success', 'value'=>'door1', 'name'=>'submit']) ?>
        <?= Html::submitButton("Porte 2", ['class' => 'btn btn-success', 'value'=>'door2', 'name'=>'submit']) ?>
    </div>
    <p class="lead border border-primary">Victoire : <?= Html::encode($session->get('progress')) ?></p>

<? ActiveForm::end();