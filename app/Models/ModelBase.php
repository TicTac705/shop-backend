<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelBase extends Model
{
    public function saveAndReturn(): ModelBase
    {
        $this->save();

        return $this;
    }

    public function saveAndReturnId(): string
    {
        $this->save();

        return $this->id;
    }
}
