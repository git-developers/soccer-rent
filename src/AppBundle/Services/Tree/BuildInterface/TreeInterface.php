<?php

namespace AppBundle\Services\Tree\BuildInterface;

interface TreeInterface
{
//    public function findAll($limit = null, $offset = null);
    public function findAllParents();
    public function findAllByParent($parent);
}
