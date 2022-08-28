<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin Builder
 * @property int $id
 * @property float $price
 */
class OrderAssembly extends Model
{
    use HasFactory;

    protected $table = "order_assemblies";

    public $timestamps = false;

    protected $fillable = [
        'amount',
        'order_id',
        'assembly_id',
        'price',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function assembly(): BelongsTo
    {
        return $this->belongsTo(Assembly::class);
    }
}
