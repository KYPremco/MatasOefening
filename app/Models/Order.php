<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Builder
 * @property int $id
 */
class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        'user_id',
        'type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assemblies(): HasMany
    {
        return $this->hasMany(OrderAssembly::class);
    }

    public function scopeFilterName($query, $name)
    {
        $query->when($name)
            ->whereHas('assemblies.assembly', function ($query) use($name) {
                $query->FilterNameOrComponentName($name);
            });
        return $query;
    }
}
