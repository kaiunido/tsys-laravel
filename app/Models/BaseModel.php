<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use \Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Models
 *
 * @mixin EloquentBuilder
 */
abstract class BaseModel extends Model
{}
