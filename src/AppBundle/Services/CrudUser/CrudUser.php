<?php

namespace AppBundle\Services\CrudUser;

use AppBundle\Services\CrudUser\Builder\CrudUserMapper;
use AppBundle\Services\CrudUser\Builder\DataTableMapper;

class CrudUser
{

    public function getCrudMapper()
    {
        return new CrudUserMapper();
    }

    public function getDataTableMapper()
    {
        return new DataTableMapper();
    }

}