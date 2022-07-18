<?php

namespace App\Rules;

use App\Models\ModelBase;
use Illuminate\Contracts\Validation\Rule;

class NotExistsInDataBase implements Rule
{
    private ModelBase $model;
    private string $fieldName;

    public function __construct(ModelBase $model, string $fieldName)
    {
        $this->model = $model;
        $this->fieldName = $fieldName;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $result = $this->model::query()->where($this->fieldName, '=', $value)->first();

        return $result === null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute exists in table ' . $this->model->getTable();
    }
}
