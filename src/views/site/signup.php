<?php
use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
?>
<?php
    $this->title = 'Inscription';
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Veuillez remplir le formulaire pour vous inscrire</p>

<? $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'username')->textInput(['autofocus'=>true]); ?>
<?= $form->field($model, 'password')->passwordInput(); ?>
<?= $form->field($model, 'confirmPassword')->passwordInput(); ?>
<? if(isset($message)){
    echo "<div class='alert alert-warning' role='alert'>$message</div>";
} ?>

<div class="form-group">
    <?= Html::submitButton('Inscription!', ['class' => 'btn btn-primary']) ?>
</div>

<? ActiveForm::end();