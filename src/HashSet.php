<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\DataStructure;

/**
 * Class HashSet
 *
 * @author Nate Brunette <n@tebru.net>
 */
class HashSet extends AbstractSet
{
    /**
     * Constructor
     *
     * Use [@see AbstractSet::add] to ensure uniqueness
     *
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            $this->add($element);
        }
    }
}
