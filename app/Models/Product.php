<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int            $id             Уникальный идентификатор товара
 * @property string         $name           Имя товара
 * @property string|null    $description    Описание товара
 * @property string         $price          Цена товара
 * @property int            $category_id    ID категории
 * @property Carbon|null    $created_at     Дата создания
 * @property Carbon|null    $updated_at     Дата обновления
 * @property Carbon|null    $deleted_at     Дата удаления 
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    /**
     * Товар принадлежит категории
     * 
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
