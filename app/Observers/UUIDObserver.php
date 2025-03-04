<?php

namespace App\Observers;
use Illuminate\Support\Str;

class UUIDObserver
{
    
    public function creating($model)
    {
        $model->uuid = (string) Str::uuid();
    }
}
