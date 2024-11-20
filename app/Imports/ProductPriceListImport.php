<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductPriceListImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        /// remove excel header /////
        $first_key = $rows->keys()->first();
        $rows = $rows->forget($first_key);
        
        foreach ($rows as $row) {
            $product = Product::find($row[0]);
            $product->price = $row[1];
            $product->stock = $row[2];
            $product->save();
        }
    }
}