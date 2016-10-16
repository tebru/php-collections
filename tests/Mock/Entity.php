<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Collection\Test\Mock;

/**
 * Class Entity
 *
 * @author Nate Brunette <n@tebru.net>
 */
class Entity
{
    public $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}
