<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Component extends Model
{
    use HasFactory;

    protected $table = "components";

    protected $fillable = [
        'name',
        'type',
        'image',
        'price',
    ];

    public function assemblies(): BelongsToMany
    {
        return $this->belongsToMany(Assembly::class)->withPivot("location");
    }
}
