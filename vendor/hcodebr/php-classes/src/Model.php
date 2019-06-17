<?php

namespace Hcode;

class Model {

    private $values = [];

        public function __call($name, $args)
    {

        $method = substr($name, 0, 3);//pega 3 caracter começand da posição 0
        $fieldName = substr($name, 3, strlen($name));//pega a quantidade de string do nome começando à partir da posição 3

        switch ($method)
        {
            case "get":
                return (isset($this->values[$fieldName]))?$this->values[$fieldName]:NULL;
            break;

            case "set":
                $this->values[$fieldName] = $args[0];
            break;

        }

    }

    public function setData($data = array())
    {

        foreach ($data as $key => $value){

            $this->{"set".$key}($value);
        }

    }

    public function getValues()
    {

        return $this->values;

    }

}

