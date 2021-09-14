<?php

use yii\helpers\Html;
use \yii\widgets\ActiveForm;

/* @var $door app\models\core\Door */
/* @var $class app\models\core\Classe */
/* @var $user app\models\backend\User */
$session = Yii::$app->session;
$session->open();
$monster = $door->action();
$this->title = 'Combat';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title) ?></h1>

    <? $form = ActiveForm::begin(['id' => 'form']); ?>
<div class="row container text-center">
    <div class="col-sm-6">
        <h2><?= Html::encode($user->username) ?> - <?= Html::encode($user->class) ?></h2>
        <img src="../../images/<?= $user->image?>" width="300" height="400">
        <ul class="list-group">
            <div class="row">
                <li class="list-group-item col-sm-4">Santé : </li>
                <li id="userHealth" class="list-group-item col-sm-4"> <?=Html::encode($session->get('userHealth')) ?></li>
                <li class="list-group-item col-sm-4"><?= Html::encode($user->health) ?></li>
            </div>
            <li class="list-group-item">Force : <?= Html::encode($session->get('userStrength')) ?></li>
            <li class="list-group-item">Défense : <?= Html::encode($session->get('userDefense')) ?></li>
        </ul>
    </div>
    <div class="col-sm-6">
        <h2><?= Html::encode($monster->name) ?> - Niveau <?= Html::encode($monster->level) ?></h2>
        <img src="../../images/<?= $monster->image?>" width="300" height="400">
        <ul class="list-group">
            <div class="row">
                <li class="list-group-item col-sm-4">Santé : </li>
                <li id="monsterHealth" class="list-group-item col-sm-4"> <?=Html::encode($session->get('monsterHealth')) ?></li>
                <li class="list-group-item col-sm-4"><?= Html::encode($monster->health) ?></li>
            </div>
            <li class="list-group-item">Force : <?= Html::encode($monster->strength) ?></li>
            <li class="list-group-item">Défense : <?= Html::encode($monster->defense) ?></li>
        </ul>
    </div>
</div>

<p class="lead text-center" id="course"></p>

<div class="form-check text-center">
    <input class="form-check-input" type="radio" name="type" id="attack" value="attack" checked>
    <label class="form-check-label" for="attack" id="labAttack">
        Attaquer
    </label>
</div>
<div class="form-check text-center">
    <input class="form-check-input" type="radio" name="type" id="spell" value="spell">
    <label class="form-check-label" for="spell" id="labSpell">
        <?= Html::encode($class->spell) ?>
    </label>
</div>
<div class="form-group text-center">
    <?= Html::submitButton('Go!', ['class' => 'btn btn-primary', 'value'=>'attack', 'name'=>'submit', 'id' => 'go']) ?>
</div>
<div class="text-center" id="bottom">

</div>
<? ActiveForm::end(); ?>


<script src="../../javascript/apiBattle.js"></script>
