<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\DataStructure;

/**
 * Class HashMap
 *
 * [@see MapInterface] implementation
 *
 * @author Nate Brunette <n@tebru.net>
 */
class HashMap extends AbstractMap
{
    /**
     * Constructor
     *
     * @param array $mappings
     */
    public function __construct(array $mappings = [])
    {
        $this->mappings = $mappings;
    }
}
