<?php

namespace AppBundle\Services\Tree;

use AppBundle\Services\Tree\Builder\TreeMapper;

class Tree
{

    public function getTreeMapper()
    {
        return new TreeMapper();
    }

}