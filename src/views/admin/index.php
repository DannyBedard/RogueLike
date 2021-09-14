<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Liste des monstres';
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= Html::encode($this->title) ?></h1>

<? $form = ActiveForm::begin(); ?>

    <ul class="list-group">
        <?php foreach ($monsters as $monster): ?>
        <div class="row">
            <li class="list-group-item col-sm-2">
                <img src="../../images/<?= $monster->image?>" width="30" height="40">
                <?= Html::encode($monster->name) ?>
            </li>
            <li class="list-group-item col-sm-2">
                Niveau :
                <?= Html::encode($monster->level) ?>
            </li>
            <li class="list-group-item col-sm-1">
                Vie :
                <?= Html::encode($monster->health) ?>
            </li>
            <li class="list-group-item col-sm-1">
                Force :
                <?= Html::encode( $monster->strength) ?>
            </li>
            <li class="list-group-item col-sm-2">
                Défense :
                <?= Html::encode( $monster->defense) ?>
            </li>
            <li class="list-group-item col-sm-2">
                Récompense :
                <?= Html::encode( $monster->loot) ?>
            </li>
                <button class="btn btn-primary col-2" type="submit" name="submit" value="<?= $monster->id ?>">Modifier / Supprimer</button>
        </div>
        <?php endforeach; ?>
    </ul>

<? ActiveForm::end() ?>


<?= LinkPager::widget(['pagination' => $pagination]);
