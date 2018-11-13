<?php

namespace AppBundle\Services\TreeToAssign;

use AppBundle\Services\TreeToAssign\Builder\BoxMapper;
use AppBundle\Services\TreeToAssign\Builder\BoxLeftMapper;
use AppBundle\Services\TreeToAssign\Builder\BoxRightMapper;

class TreeToAssign
{

    public function getBoxMapper()
    {
        return new BoxMapper();
    }

    public function getBoxLeftMapper()
    {
        return new BoxLeftMapper();
    }

    public function getBoxRightMapper()
    {
        return new BoxRightMapper();
    }

}