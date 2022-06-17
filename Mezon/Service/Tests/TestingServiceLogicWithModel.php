<?php
namespace Mezon\Service\Tests;

use Mezon\Service\ServiceLogicWithModel;
use Mezon\Service\ServiceModel;

class TestingServiceLogicWithModel extends ServiceLogicWithModel
{

    public function getModel(): ServiceModel
    {
        return $this->model;
    }
}
