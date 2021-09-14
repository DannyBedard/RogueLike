<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Embermania</h1>

        <?         if (Yii::$app->user->isGuest) {
            echo '        <p class="lead">Vous devez avoir un compte pour jouer au jeu</p>
        <p><a class="btn btn-lg btn-primary" href="site/signup">Créer un compte</a></p>
        <p class="lead">Ou si vous avez déjà un compte</p>
        <p><a class="btn btn-lg btn-success" href="site/login">Connexion</a></p>';
        }
        elseif (Yii::$app->user->can('ready')){
                                    echo '        <p class="lead">Allez voir les portes</p>
        <p><a class="btn btn-lg btn-primary" href="game/">Jouer</a></p>
        <p class="lead">Améliorer vos compétences</p>
        <p><a class="btn btn-lg btn-success" href="store/">Magasin</a></p>';
        }
        elseif (Yii::$app->user->can('admin')){
            echo '        <p class="lead">Voir la liste des monstres</p>
        <p><a class="btn btn-lg btn-primary" href="admin/">Modifier</a></p>
        <p class="lead">Créer un nouveau monstre</p>
        <p><a class="btn btn-lg btn-success" href="admin/create">Créer</a></p>';
        }
        else{
                        echo '        <p class="lead">Pour commencer, choisissez une classe</p>
        <p><a class="btn btn-lg btn-primary" href="game/create">Choisir classe</a></p>';
        }?>

    </div>

</div>
