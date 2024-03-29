<?php

namespace frontend\components;


use common\models\Contest;
use common\models\Project;
use common\models\Voter;

class Controller extends \common\components\Controller
{
    public $voter;
    public $voterProject;

    public function init()
    {
        parent::init();
        if($this->user->identity) {
            $this->voter = Voter::findOne(['id' => $this->user->identity->id]);
            $this->voterProject = $this->voter->getProjects()->one();
        }
    }

}