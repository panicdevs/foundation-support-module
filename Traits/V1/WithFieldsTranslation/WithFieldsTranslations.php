<?php

declare(strict_types=1);

namespace Foundation\Support\Traits\V1\WithFieldsTranslation;

trait WithFieldsTranslations
{
    /**
     * Magic 🪄
     */
    public function __call($name, $arguments)
    {
        $key         = "v1.{$this->module()}::fields.{$this->attribute()}.{$name}";
        $translation = __($key);

        return $key === $translation ? null : $translation;
    }

    /**
     * Get the module
     */
    protected function module(): string
    {
        return str(str(get_called_class())->explode('\\')[1])->snake()->lower()->toString();
    }

    /**
     * Get the translation
     *
     * @params ?string
     */
    public function trans(?string $label = null): string
    {
        $label ??= 'label';

        $key   = "v1.{$this->module()}::fields.{$this->attribute()}.{$label}";
        $trans = __($key);

        return $key === $trans ? str($this->attribute())
            ->replace('_id', ' ')
            ->replace('_', ' ')
            ->title()
            ->toString() : $trans;
    }

    /**
     * Get the label
     */
    public function label(): string
    {
        return $this->trans();
    }

    /**
     * Get the table-heading-label
     */
    public function tableHeading(): string
    {
        $key     = "v1.{$this->module()}::fields.{$this->attribute()}.table_heading";
        $heading = __($key);

        return $key === $heading ? $this->label() : $heading;
    }

    /**
     * Get the placeholder
     */
    public function placeholder(): string
    {
        $key         = "v1.{$this->module()}::fields.{$this->attribute()}.placeholder";
        $placeholder = __($key);

        return $key === $placeholder ? __('Please Fill :attribute', ['attribute' => $this->label()]) : $placeholder;
    }

    /**
     * Get the color
     */
    public function color(): ?string
    {
        $key   = "v1.{$this->module()}::fields.{$this->attribute()}.color";
        $color = __($key);

        return $key === $color ? null : $color;
    }
}
