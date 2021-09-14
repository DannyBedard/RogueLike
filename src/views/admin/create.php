<?php
use yii\helpers\Html;
use \yii\widgets\ActiveForm;
?>
<?php
$this->title = 'Créer un monstre';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Veuillez remplir le formulaire pour créer un monstre</p>

<? $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'name')->textInput(['autofocus'=>true]); ?>
<?= $form->field($model, 'level')->input('number'); ?>
<?= $form->field($model, 'health')->input('number'); ?>
<?= $form->field($model, 'strength')->input('number'); ?>
<?= $form->field($model, 'defense')->input('number'); ?>
<?= $form->field($model, 'loot')->input('number'); ?>
<?= $form->field($model, 'image')->fileInput(); ?>
<?= $form->field($model, 'id')->hiddenInput(['value'=>0, 'readonly'])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Ajouter', ['class' => 'btn btn-primary']) ?>
    </div>

<? ActiveForm::end();