<?php

namespace app\models\core;

use app\models\core\Door;
use Yii;

class DoorBonus extends Door
{
    public $choice;
    public $message;
    public $image;
    public function __construct()
    {
        $this->choice = rand(1, 2);
        $this->name = 'Bonus';
        $this->action = 'bonus';
    }

    public function action(){
        $session = Yii::$app->session;
        $session->open();
        if($this->choice === 1)
        {
            $session->set('userStrength', $session->get('userStrength') + 2);
            $this->message = "Vous trouvez un meule et en profiter pour aiguiser votre arme pour une bonus de +2 de force.";
            $this->image = "Meule.jpg";
        }
        if($this->choice === 2)
        {
            $session->set('userDefense', $session->get('userDefense') + 2);
            $this->message = "Vous remplacer certaine pièce de votre armure pour un bonus de +2 en défense.";
            $this->image = "Armure.jpg";
        }
        $this->updateSession();
    }
}