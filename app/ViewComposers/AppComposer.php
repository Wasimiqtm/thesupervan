<?php

namespace App\ViewComposers;

use App\Models\Product;
use Illuminate\View\View;

class AppComposer {

    public $items = [];

    public function __construct() {
        $data = [
            'brands' => Product::all()
        ];

        $this->items[] = $data;
    }

    public function compose(View $view) {
        $view->with('items', end($this->items));
    }
}
