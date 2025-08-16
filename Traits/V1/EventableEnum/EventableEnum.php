<?php

declare(strict_types=1);

namespace Foundation\Support\Traits\V1\EventableEnum;

trait EventableEnum
{
    /**
     * Get the event name
     */
    public function event(): string
    {
        return $this->value;
    }

    /**
     * Call the system event
     */
    public function fire(...$params): void
    {
        event($this->value, $params);
    }
}
