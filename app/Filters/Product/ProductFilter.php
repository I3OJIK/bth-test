<?php

namespace App\Filters\Product;

use App\Filters\Abstracts\BaseFilter;
use App\Filters\Product\Filters\CategoryFilter;

class ProductFilter extends BaseFilter
{
    protected array $filters = [
        'category' => CategoryFilter::class, 
    ];
}