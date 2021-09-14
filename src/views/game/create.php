<?php
use yii\helpers\Html;
use \yii\widgets\ActiveForm;

/* @var $class app\models\core\Classe */

$this->title = 'Classe';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-sm-6">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Veuillez choisir une classe pour votre joueur</p>

        <? $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'choice')->dropDownList($model->choice, ['value' => empty(false),'class' => 'btn-group btn btn-default']); ?>

        <p class="lead"><?= Html::encode($class->description) ?></p>
    </div>

    <div class="col-sm-6 text-center">
        <h2><?= Html::encode($class->name) ?></h2>
        <img src="../../images/<?= $class->image?>" width="300" height="400">
        <ul class="list-group">
            <li class="list-group-item">Santé : <?= Html::encode($class->health) ?></li>
            <li class="list-group-item">Force : <?= Html::encode($class->strength) ?></li>
            <li class="list-group-item">Défense : <?= Html::encode($class->defense) ?></li>
        </ul>
    </div>
</div>

    <div class="form-group text-center">
        <?= Html::submitButton('Choisir', ['class' => 'btn btn-primary', 'value'=>'submit', 'name'=>'submit']) ?>
        <?= Html::submitButton('Détails', ['class' => 'btn btn-secondary', 'value'=>'detail', 'name'=>'submit']) ?>
    </div>

<? ActiveForm::end();
