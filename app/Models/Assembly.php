<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Assembly extends Model
{
    use HasFactory;

    protected $table = "assemblies";

    protected $fillable = [
        'name',
        'image',
        'price',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function components(): BelongsToMany
    {
        return $this->belongsToMany(Component::class)->withPivot("location");
    }
}
