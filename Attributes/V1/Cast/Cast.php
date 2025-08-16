<?php

declare(strict_types=1);

namespace Foundation\Support\Attributes\V1\Cast;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Cast
{
    public function __construct(public string $type)
    {
    }
}
