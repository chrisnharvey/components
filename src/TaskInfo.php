<?php

namespace Encore\Development;

use Robo\TaskInfo as BaseTaskInfo;

class TaskInfo extends BaseTaskInfo
{
    public function getName()
    {
        return 'task:'.parent::getName();
    }
}