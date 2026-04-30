<?php
namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\BannerAmazing;
use Illuminate\Http\Request;

class BannerAmazingController extends Controller
{
    public function edit()
    {
        $banner = BannerAmazing::first();
        return view('admin.banner_amazing.edit', compact('banner'));
    }

    public function update(Request $request)
    {
        $banner = BannerAmazing::firstOrNew();

        if ($request->hasFile('image')) {
            $path = ImageHelper::upload($request->file('image'), 'banners');
            $banner->image = $path;
        }

        $banner->title = $request->title;
        $banner->festival_title = $request->festival_title;
        $banner->festival_description = $request->festival_description;
        $banner->discount_percent = $request->discount_percent;
        $banner->start_date = $request->start_date;
        $banner->end_date = $request->end_date;
        $banner->colors = $request->colors;
        $banner->button_text = $request->button_text;
        $banner->button_link = $request->button_link;
        $banner->countdown_end = $request->countdown_end;

        $banner->save();

        return back()->with('success','بنر بروزرسانی شد');
    }
}

