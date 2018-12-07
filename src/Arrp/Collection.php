<?php

namespace Arrp;

class Collection extends AbstractDataStructure{

    private $dataStructure;

    public function __construct(array $dataStructure = [])
    {
        $this->dataStructure = $dataStructure;
    }

    public function all() {
        return $this->dataStructure;
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->dataStructure)) as $key => $value) {
            if($key === $offset) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param $array
     * @param $offset
     * @param $offsetValue
     * @return mixed
     */
    private function recursiveScanOffsetGet($array, $offset) {
        foreach ($array as $key => $value) {
            if($key === $offset){
                return $value;
            }

            if (is_array($value)) {
               return $this->recursiveScanOffsetGet($value, $offset);
            }
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->dataStructure = $this->recursiveScanOffsetSet($this->dataStructure, $offset, $value);
    }

    /**
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
       $this->dataStructure = $this->recursiveScanOffsetUnset($this->dataStructure, $key);
    }

    /**
     * Recursively walks the array without breaking the iteration with return
     *
     * @return \Generator
     */
    public function walkRecursive(): \Generator {
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->dataStructure)) as $key => $value) {
            yield $key => $value;
        }
    }

    /**
     * @param bool $countRecursive
     * @return int
     */
    public function count($countRecursive = false)
    {
        return true === $countRecursive ? count($this->dataStructure, COUNT_RECURSIVE) : count($this->dataStructure);
    }

    /**
     * @param string $json
     * @return $this|mixed
     */
    public function fromJson(string $json)
    {
        $result = json_decode($json, true);

        if(JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(sprintf("The argument provided to %s must be of type json.", __FUNCTION__));
        }

        $this->dataStructure = $result;

        return $this;
    }

    /**
     * @return false|mixed|string
     */
    public function toJson()
    {
        return json_encode($this->dataStructure);
    }

    /**
     * Internal use
     *
     * @param $array
     * @param $offset
     * @return mixed
     */
    private function recursiveScanOffsetUnset(&$array, $offset) {
        foreach ($array as $key => &$value) {
            if($key === $offset){
                unset($array[$key]);
                return $array;
            }

            if (is_array($value)) {
                $this->recursiveScanOffsetUnset($value, $offset);
            }
        }

        return $array;
    }

    /**
     * @param $array
     * @param $offset
     * @param $offsetValue
     * @return mixed
     */
    private function recursiveScanOffsetSet(&$array, $offset, $offsetValue) {
        foreach ($array as $key => &$value) {
            if($key === $offset){
                $array[$key] = $offsetValue;
            }

            if (is_array($value)) {
                $this->recursiveScanOffsetSet($value, $offset, $offsetValue);
            }
        }

        return $array;
    }
}