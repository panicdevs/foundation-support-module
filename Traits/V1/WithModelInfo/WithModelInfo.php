<?php

declare(strict_types=1);

namespace Foundation\Support\Traits\V1\WithModelInfo;

use Illuminate\Database\Eloquent\Model;
use Foundation\Support\Traits\V1\HasModelFields\HasModelFields;

trait WithModelInfo
{
    use HasModelFields;

    /**
     * Get the table name
     */
    public static function table(): string
    {
        $model = str(get_called_class())
            ->replaceLast('Fields', '')
            ->toString();

        return resolve($model)->getTable();
    }

    /**
     * Get the class fqcn
     */
    public static function model(): string
    {
        return str(get_called_class())
            ->replaceLast('Fields', '')
            ->toString();
    }

    /**
     * Get the model
     */
    public static function resolve(): Model
    {
        return resolve(static::model());
    }
}
