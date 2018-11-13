<?php

namespace AppBundle\Services\Common;

use Symfony\Component\HttpFoundation\Request;

class Base
{

    protected function handleSearchValueBase(Request $request, $boxSearch)
    {
        $fields = $request->get('fields');
        $fields = is_array($fields) ? $fields : [];

        foreach ($fields as $key => $value){
            if($value['name'] == $boxSearch){
                return trim($value['value']);
            }
        }

        return null;
    }

    protected function handleSelectedIdSingle(Request $request, $boxValue)
    {
        $fields = $request->get('fields');
        $fields = is_array($fields) ? $fields : [];

        foreach ($fields as $key => $value){
            $id = trim($value['value']);
            if($value['name'] == $boxValue && is_numeric($id)){
                return $id;
            }
        }

        return null;
    }

    protected function handleSelectedIdArray(Request $request, $boxValueHidden)
    {
        $out = [];
        $fields = $request->get('fields');
        $fields = is_array($fields) ? $fields : [];

        foreach ($fields as $key => $value){
            $id = trim($value['value']);
            if($value['name'] == $boxValueHidden){ //  && !empty($id)
                $out[] = $id;
            }
        }

        return $out;
    }

    protected function isValidKey($key, $defaults)
    {
        if (!array_key_exists($key, $defaults)) {
            throw new \Error(get_called_class() . ': el key "'.$key.'" que ingreso no existe en el mapper');
        }
        return;
    }

}