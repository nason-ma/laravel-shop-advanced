<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ProductProperty
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $value
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperty whereValue($value)
 * @mixin \Eloquent
 */
class ProductProperty extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name', 'value'];

    // 没有 created_at 和 updated_at 字段
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
