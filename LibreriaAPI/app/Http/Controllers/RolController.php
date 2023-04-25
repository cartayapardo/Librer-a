<?php

namespace App\Http\Controllers;

use App\Models\Rol;

class RolController extends BaseController
{
    public function __construct(Rol $model)
    {
        parent::__construct($model);
    }
}
