<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection;

/**
 * Class MapEntry
 *
 * This is the object that gets returned as part of a call to
 * [@see MapInterface::entrySet()].
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MapEntry
{
    /**
     * The map key
     *
     * @var mixed
     */
    public $key;

    /**
     * The map value
     *
     * @var mixed
     */
    public $value;

    /**
     * Constructor
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
