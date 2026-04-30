<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\BannerAmazing as BannerModel;

class BannerAmazing extends Component
{
    public $banner;

    public function __construct()
    {
        $this->banner = BannerModel::first();
    }

    public function render()
    {
        return view('components.banner-amazing');
    }
}
