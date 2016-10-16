<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test\Mock;

use Tebru\Collection\HashSet;

/**
 * Class ModifiedHashSet
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ModifiedHashSet extends HashSet
{
    /**
     * @param Entity $element
     * @return mixed
     */
    protected function getKey($element)
    {
        return $element->value;
    }
}
