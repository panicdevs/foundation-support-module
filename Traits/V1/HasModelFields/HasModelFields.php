<?php

declare(strict_types=1);

namespace Foundation\Support\Traits\V1\HasModelFields;

use Foundation\Support\Attributes\V1\Appends\Appends;
use Foundation\Support\Attributes\V1\Cast\Cast;
use Foundation\Support\Attributes\V1\EagerLoad\EagerLoad;
use Foundation\Support\Attributes\V1\Fillable\Fillable;
use Foundation\Support\Attributes\V1\Hidden\Hidden;
use Foundation\Support\Attributes\V1\Selectable\Selectable;
use Foundation\Support\Attributes\V1\TableColumn\TableColumn;
use Illuminate\Support\Collection;
use Foundation\Support\Traits\V1\WithFieldsTranslation\WithFieldsTranslations;
use ReflectionEnum;
use ReflectionEnumUnitCase;
use ReflectionException;

trait HasModelFields
{
    use WithFieldsTranslations;

    #region Attribute
    /**
     * Get the case's value
     */
    public function attribute(): string
    {
        return $this->value;
    }

    /**
     * Get cases with the specified attribute.
     */
    private static function getCasesWithAttribute(string $attributeClass): Collection
    {
        $reflectionEnum = new ReflectionEnum(self::class);

        return collect($reflectionEnum->getCases())
            ->filter(fn (ReflectionEnumUnitCase $case) => !empty($case->getAttributes($attributeClass)))
            ->map(fn (ReflectionEnumUnitCase $case) => $case->getValue());
    }
    #endregion

    #region Fillable Cases
    /**
     * Get fillable cases
     */
    protected static function fillable(): array
    {
        return self::cases();
    }

    /**
     * Get the fillable fields
     *
     * @return string[]
     */
    public static function fillableFields(): array
    {
        return self::getCasesWithAttribute(Fillable::class)->pluck('value')->toArray();
    }
    #endregion

    #region Appends
    /**
     * Get the appended attributes
     *
     * @return string[]
     */
    public static function appendedAttributes(): array
    {
        return self::getCasesWithAttribute(Appends::class)->pluck('value')->toArray();
    }
    #endregion

    #region With
    /**
     * Get the eager-loading relations attributes
     *
     * @return string[]
     */
    public static function eagerLoadAttributes(): array
    {
        return self::getCasesWithAttribute(EagerLoad::class)->pluck('value')->toArray();
    }
    #endregion

    #region Selectable Fields
    /**
     * Get all the selectable fields as an array.
     */
    public static function selectableFields(bool $withTableName = false): array
    {
        return self::getCasesWithAttribute(Selectable::class)
            ->map(fn($case) => $withTableName ? self::table().'.'.$case->value : $case->value)
            ->toArray();
    }
    #endregion

    #region Table Column Fields
    /**
     * Get all the table column fields as an array.
     */
    public static function tableColumnFields(bool $withTableName = false): array
    {
        return self::getCasesWithAttribute(TableColumn::class)
            ->map(fn($case) => $withTableName ? self::table().'.'.$case->value : $case->value)
            ->toArray();
    }
    #endregion

    #region Guarded
    /**
     * Get guarded cases
     */
    protected static function guarded(): array
    {
        return [];
    }

    /**
     * Get the guarded fields
     *
     * @return string[]
     */
    public static function guardedFields(): array
    {
        return collect(self::guarded())
            ->map(fn (self $case) => $case->attribute())
            ->toArray();
    }
    #endregion

    #region Casts
    /**
     * Get all the cast mappings as an associative array.
     */
    public static function getCasts(): array
    {
        $reflectionEnum = new ReflectionEnum(self::class);

        $casts = [];
        foreach ($reflectionEnum->getCases() as $case)
        {
            $castAttributes = $case->getAttributes(Cast::class);
            if (!empty($castAttributes))
            {
                $casts[$case->getValue()->value] = $castAttributes[0]->newInstance()->type;
            }
        }

        return $casts;
    }

    /**
     * Get the cast type for a specific field.
     * @throws ReflectionException
     */
    public static function getCastForField(string $field): ?string
    {
        $reflectionEnum = new ReflectionEnum(self::class);
        $case           = $reflectionEnum->getCase($field);

        $castAttributes = $case->getAttributes(Cast::class);
        if (!empty($castAttributes))
        {
            return $castAttributes[0]->newInstance()->type;
        }

        return null;
    }

    /**
     * Get the guarded fields
     */
    public static function castedFields(): array
    {
        return self::getCasts();
    }
    #endregion

    #region Hidden

    /**
     * Get the guarded fields
     *
     * @return string[]
     */
    public static function hiddenFields(): array
    {
        return self::getCasesWithAttribute(Hidden::class)->pluck('value')->toArray();
    }
    #endregion
}
