<?php

namespace Arrp;

class Collection extends AbstractDataStructure{

    private $dataStructure;

    public function __construct(array $dataStructure = [])
    {
        $this->dataStructure = $dataStructure;
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($key)
    {
       $iterator = new \RecursiveIteratorIterator()
    }

    public function count($countRecursive = false)
    {
        return true === $countRecursive ? count($this->dataStructure, COUNT_RECURSIVE) : count($this->dataStructure);
    }

    public function fromJson(string $json)
    {
        $result = json_decode($json, true);

        if(JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(sprintf("The argument provided to %s must be of type json.", __FUNCTION__));
        }

        $this->dataStructure = $result;

        return $this;
    }

    public function toJson()
    {
        return json_encode($this->dataStructure);
    }
}