<?php

declare(strict_types=1);

namespace Foundation\Support\Attributes\V1\EagerLoad;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT | Attribute::IS_REPEATABLE)]
class EagerLoad
{
    public function __construct()
    {
    }
}
