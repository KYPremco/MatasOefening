<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Builder
 * @property string $name
 */
class Manufacturer extends Model
{
    use HasFactory;

    protected $table = "manufacturers";

    protected $fillable = [
        'name',
    ];

    public function assemblies(): HasMany
    {
        return $this->hasMany(Assembly::class);
    }
}
