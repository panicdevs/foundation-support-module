<?php

declare(strict_types=1);

namespace Foundation\Support\Attributes\V1\Hidden;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT | Attribute::IS_REPEATABLE)]
class Hidden
{
}
