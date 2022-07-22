<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Builder
 * @property int $id
 * @property string $name
 * @property string $image
 * @property float $price
 */
class Assembly extends Model
{
    use HasFactory;

    protected $table = "assemblies";

    protected $fillable = [
        'name',
        'image',
        'price',
        'manufacturer_id'
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
        return $this->belongsToMany(Component::class, "assembly_components")->withPivot("location");
    }

    public function scopeFilterName($query, $name)
    {
        $query->when($name)->where("name", "like", "%" . $name . "%");
        return $query;
    }
}
