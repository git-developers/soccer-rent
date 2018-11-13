<?php

namespace AppBundle\Services\Crud;

use AppBundle\Services\Crud\Builder\CrudMapper;
use AppBundle\Services\Crud\Builder\DataTableMapper;

class Crud
{

    public function getCrudMapper()
    {
        return new CrudMapper();
    }

    public function getDataTableMapper()
    {
        return new DataTableMapper();
    }

}