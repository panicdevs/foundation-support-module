<?php

declare(strict_types=1);

namespace Foundation\Support\Traits\V1\HasFieldsEnum;

trait HasFieldsEnum
{
    /**
     * Get fields enum
     */
    protected function fields(): string
    {
        return get_called_class().'Fields';
    }

    /**
     * Get the fillable attributes for the model.
     *
     * @return array<string>
     */
    public function getFillable(): array
    {
        return $this->fields()::fillableFields();
    }

    /**
     * Get the appendable attributes
     */
    public function getArrayableAppends(): array
    {
        return $this->fields()::appendedAttributes();
    }

    /**
     * Get eager loading relations
     */
    public function getWith(): array
    {
        return $this->fields()::eagerLoadAttributes();
    }

    /**
     * Get the guarded attributes for the model.
     *
     * @return array<string>
     */
    public function getGuarded(): array
    {
        return $this->fields()::guardedFields();
    }

    /**
     * Get the attributes that should be cast.
     */
    public function casts(): array
    {
        return $this->fields()::castedFields();
    }

    /**
     * Get the hidden attributes for the model.
     *
     * @return array<string>
     */
    public function getHidden(): array
    {
        return $this->fields()::hiddenFields();
    }


    /**
     * Get a unique key based on shield-policy naming convention
     */
    public static function policyKey(): string
    {
        return str(basename(str_replace('\\', '/', get_called_class())))
            ->snake('::')
            ->lower()
            ->toString()
        ;
    }
}
