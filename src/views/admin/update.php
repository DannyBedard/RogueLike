<?php
use yii\helpers\Html;
use \yii\widgets\ActiveForm;
?>
<?php
$this->title = 'Modifier un monstre';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Veuillez remplir le formulaire pour modifier un monstre</p>
    <img src="../../images/<?= $monster->image?>" width="150" height="200">

<? $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'name')->textInput(['autofocus'=>true, 'value'=>$monster->name]); ?>
<?= $form->field($model, 'level')->textInput(['type'=>'number', 'value'=>$monster->level]); ?>
<?= $form->field($model, 'health')->textInput(['type'=>'number', 'value'=>$monster->health]); ?>
<?= $form->field($model, 'strength')->textInput(['type'=>'number', 'value'=>$monster->strength]); ?>
<?= $form->field($model, 'defense')->textInput(['type'=>'number', 'value'=>$monster->defense]); ?>
<?= $form->field($model, 'loot')->textInput(['type'=>'number', 'value'=>$monster->loot]); ?>
<?= $form->field($model, 'id')->hiddenInput(['value'=>$monster->id, 'readonly'])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Modifier', ['class' => 'btn btn-primary', 'name' => 'submit', 'value'=>'update']) ?>
        <?= Html::submitButton('Supprimer', ['class' => 'btn btn-danger', 'name' => 'submit', 'value'=>'delete']) ?>
    </div>

<? ActiveForm::end();