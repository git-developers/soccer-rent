<?php

namespace AppBundle\Services\CrudUser\BuildInterface;

interface CrudUserInterface
{
    public function findAll($limit = null, $offset = null);
}
