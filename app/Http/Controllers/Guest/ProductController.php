<?php

namespace App\Http\Controllers\Guest;

use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Report;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tagIds = array_filter($request->input('filter.tags', [])); // 過濾掉 null 值

        $products = QueryBuilder::for(Product::class)
            ->allowedFilters([
                'name',
                AllowedFilter::callback('tags', function ($query) use ($tagIds) {
                    if (! empty($tagIds)) {
                        $query->whereHas('tags', function ($query) use ($tagIds) {
                            $query->whereIn('tags.id', $tagIds);
                        }, '=', count($tagIds));
                    }
                }),
            ])
            ->with(['media', 'user', 'tags'])
            ->where('status', ProductStatus::Active->value)
            ->paginate(6)
            ->withQueryString();

        $allTags = Tag::whereNull('deleted_at')->get();

        return view('guest.products.index', compact('products', 'allTags'));
    }

    public function show(Product $product): View
    {
        $messages = $product->messages()->with('user')->oldest()->paginate(10);
        $reports = Report::where('type', '商品')->get()->mapWithKeys(function ($item) {
            return [$item->id => json_decode($item->name, true)['zh_TW']];
        });

        return view('guest.products.show', compact('messages', 'product', 'reports'));
    }
}
