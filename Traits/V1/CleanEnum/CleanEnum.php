<?php

declare(strict_types=1);

namespace Foundation\Support\Traits\V1\CleanEnum;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Throwable;
use ValueError;

trait CleanEnum
{
    /**
     * Get the translation's file key
     */
    public static function translationKey(): string
    {
        return self::shortName();
    }

    /**
     * Get the enum short name
     */
    private static function shortName(bool $lower = true): string
    {
        $_name = basename(str_replace('\\', '/', get_called_class()));

        return $lower ? Str::snake($_name) : $_name;
    }

    /**
     * Get the module name
     */
    private static function moduleName(bool $lower = true): string
    {
        $_name = explode('\\', __CLASS__)[1];

        return $lower ? str($_name)->snake()->lower()->toString() : str($_name)->snake()->toString();
    }

    /**
     * Get pairs
     */
    public static function pairs(): Collection
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->trans()]);
    }

    /**
     * Translate case
     */
    public function trans(): string
    {
        $key         = 'v1.'.self::moduleName().'::enum.'.self::shortName().'.'.$this->attribute();
        $translation = __($key);
        return $key === $translation ? str($this->attribute())->title()->toString() : $translation;
    }

    /**
     * Get the translation's file colors key
     */
    public static function translationColorsKey(): string
    {
        return 'colors';
    }

    /**
     * Get the case color
     */
    public function color(): string|array
    {
        $key   = 'v1.'.self::moduleName().'::enum.'.self::shortName().'.'.self::translationColorsKey().'.'.$this->attribute();
        $color = __($key);
        return $key === $color ? 'gray' : $color;
    }

    /**
     * Get the translation's file icons key
     */
    public static function translationIconsKey(): string
    {
        return 'icons';
    }

    /**
     * Get the case icon
     */
    public function icon(): string
    {
        $key  = 'v1.'.self::moduleName().'::enum.'.self::shortName().'.'.self::translationIconsKey().'.'.$this->attribute();
        $icon = __($key);
        return $key === $icon ? 'heroicon-o-question-mark-circle' : $icon;
    }


    /**
     * Get case from name
     */
    public static function fromName(string $name): self
    {
        foreach (self::cases() as $case)
        {
            if ($name === mb_strtolower($case->name))
            {
                return $case;
            }
        }

        throw new ValueError("{$name} is not a valid value for backed-enum of ".self::class);
    }

    /**
     * Get case from name with a try catch block
     */
    public static function tryFromName(string $name): mixed
    {
        try
        {
            foreach (self::cases() as $case)
            {
                if ($name === mb_strtolower($case->name))
                {
                    return $case;
                }
            }

            return null;
        } catch (Throwable)
        {
            return null;
        }
    }

    /**
     * Get all values
     */
    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all values with label
     */
    public static function getAllValuesWithLabel(): array
    {
        return collect(self::cases())->map(fn ($case) => [
            'label' => __($case->value),
            'value' => $case->value,
        ])->toArray();
    }

    /**
     * Get the case value
     */
    public function attribute(): mixed
    {
        return $this->value;
    }
}
