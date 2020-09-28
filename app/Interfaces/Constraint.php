<?php
/**
 * Created by PhpStorm.
 * User: tinaa
 * Date: 18/02/19
 * Time: 08:34
 */

namespace App\Interfaces;


use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;

interface Constraint
{
    public function constraint(FormRequest $request);
}
