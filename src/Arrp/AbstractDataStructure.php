<?php

namespace Arrp;

/**
 * Class AbstractDataStructure
 * @package Arrp
 */
abstract class AbstractDataStructure implements \Countable, \ArrayAccess {
    /**
     * @param string $json
     * @return mixed
     */
    abstract public function fromJson(string $json);

    /**
     * @return mixed
     */
    abstract public function toJson();
}