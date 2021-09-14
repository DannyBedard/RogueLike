<?php
use yii\helpers\Html;
use \yii\widgets\ActiveForm;

$this->title = 'Magasin';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Veuillez choisir une amélioration, chaque amélioration coûte 50 pièces d'or</p>
    <p>Or disponible : <?= Html::encode($user->gold) ?></p>

<? $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton('Vie (' . $user->health . ')', ['class' => 'btn btn-success', 'value' => 'health', 'name' => 'submit']) ?>
        <?= Html::submitButton('Force (' . $user->strength . ')', ['class' => 'btn btn-success', 'value' => 'strength', 'name' => 'submit']) ?>
        <?= Html::submitButton('Defense (' . $user->defense . ')', ['class' => 'btn btn-success', 'value' => 'defense', 'name' => 'submit']) ?>
    </div>
<?= Html::submitButton('Remise à zéro (40 pièces par point)', ['class' => 'btn btn-warning', 'value' => 'zero', 'name' => 'submit']) ?>
<? if(isset($message)){
    echo "<div class='alert alert-warning' role='success'>$message</div>";
} ?>

<? ActiveForm::end();