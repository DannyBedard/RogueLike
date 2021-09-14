<?php
/* @var $door app\models\core\DoorHeal */

use yii\helpers\Html;

$door->action();
$this->title = 'Guérison';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="text-center">
    <img src="../../images/potion.jpg" width="400" height="600">
</div>
<div class='text-center alert alert-success' role='alert'>Vous trouvez une potion qui vous soigne 50 points de vie</div>

<div class="text-center">
    <a href="/game/" class="btn btn-success">Continuer</a>
</div>


