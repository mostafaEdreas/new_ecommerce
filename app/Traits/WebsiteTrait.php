<?php
namespace App\Traits;

use App\Models\ProductAttribute;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait WebsiteTrait {
    private function createSessionID(){
        return date('Ymdhisuu');
    }

    private function addGuistCart($data){
        $sessionID = cookie('session_id',date('Ymdhisuu'),10050);

    }
    private function ProSearch(Builder $builder): Builder
    {
        $search = request('search');
        return $builder->where(function ($query) use ($search) {
            $query->where('name_ar', 'like', '%' . $search . '%')
                ->orWhere('name_en', 'like', '%' . $search . '%')
                ->orWhereHas('Category', function ($q) use ($search) {
                    $q->where('name_ar', 'like', '%' . $search . '%')
                      ->orWhere('name_en', 'like', '%' . $search . '%');
                })
                ->orWhereHas('brand', function ($q) use ($search) {
                    $q->where('name_ar', 'like', '%' . $search . '%')
                      ->orWhere('name_en', 'like', '%' . $search . '%');
                });
        })
        ->whereHas('groups');
    }

    private function stockSearch(Builder $builder): Builder
    {
        $search = request('search');
        return $builder->whereHas('product',function($product_query)use($search){
                    $product_query->where(function ($query) use ($search) {
                        $query->where('name_ar', 'like', '%' . $search . '%')
                        ->orWhere('name_en', 'like', '%' . $search . '%')
                        ->orWhereHas('Category', function ($q) use ($search) {
                            $q->where('name_ar', 'like', '%' . $search . '%')
                            ->orWhere('name_en', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('brand', function ($q) use ($search) {
                            $q->where('name_ar', 'like', '%' . $search . '%')
                            ->orWhere('name_en', 'like', '%' . $search . '%');
                        });
                    });
                });
    }

    private function fliterProductsBuilder(Builder $builder):Builder{
        // query by search input
        if(request('search')){
           return $this->ProSearch($builder);
        }

        ///// filter
        if (request('min')||request('max') ) {
           $builder->whereHas('groups',function($q){
                if(request('min')){ $q->where('price','>=',request('min'));}
                if(request('max')){ $q->where('price','<=',request('max'));}
           });
        }else{
             $builder->whereHas('groups');
        }

         if (request('category_ids')) {
            $builder->whereIn('category_id',request('category_ids'));
         }
         if (request('brand_id')) {
            $builder->where('brand_id',request('brand_id'));
         }
         if (request('size_id')) {
            $builder->whereHas('attributes', function($q){
                $q->where('attribute_value_id',request('size_id')) ;
            });
         }
         if (request('has_stock')) {
            $builder->whereHas('groups', function($q){
                $q->where('stock','>',0) ;
            });
        }
         return $builder ;
    }

    private function filterStockBuilder(Builder $builder): Builder
    {
        // Query by search input
        if (request('search')) {
            return $this->stockSearch($builder);
        }

        // Filter by size (product_attribute_id stored as JSON in the database)
        if (request('size_id')) {
            $product_attribute_ids = ProductAttribute::where('attribute_value_id', request('size_id'))
                ->pluck('id')
                ->toArray();

            // Use a closure to add multiple orWhereJsonContains conditions
            $builder->where(function ($query) use ($product_attribute_ids) {
                foreach ($product_attribute_ids as $id) {
                    $query->orWhereJsonContains('product_attribute_id', $id);
                }
            });
        }

        // Filter by price range (min and max)
        if (request('min')) {
            $builder->where('price', '>=', request('min'));
        }

        if (request('max')) {
            $builder->where('price', '<=', request('max'));
        }

        // Filter by category or brand
        if (request('category_ids') || request('brand_id')) {
            $builder->whereHas('product', function ($q) {
                if (request('category_ids')) {
                    $q->whereIn('category_id', request('category_ids'));
                }
                if (request('brand_id')) {
                    $q->where('brand_id', request('brand_id'));
                }
            });
        }

        // Filter by available stock
        if (request('has_stock')) {
            $builder->where('stock', '>', 0);
        }

        return $builder;
    }

/**
 * @param Collection|array|Paginator $data
 * @return Collection|array|Paginator
 */
    private function filterProductsCollection(Collection|array|Paginator $data): Collection|array|Paginator
    {

        // if ($data instanceof Collection) {
        //     // Filter the collection
        //     return $data->filter(function ($item) {
        //         return $item->stock;
        //     });
        // } elseif (is_array($data)) {
        //     // Filter the array
        //     return array_filter($data, function ($item) {
        //         return $item['stock'] ?? false;
        //     });
        // } elseif ($data instanceof Paginator) {
        //     // Filter the items in the paginator
        //     $data->setCollection($data->getCollection()->filter(function ($item) {
        //         return $item->stock;
        //     }));
        //     return $data;
        // }
        return $data;
    }

}
