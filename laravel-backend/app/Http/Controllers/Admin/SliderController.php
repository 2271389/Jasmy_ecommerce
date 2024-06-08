<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlider;
use Intervention\Image\Facades\Image as Image;

class SliderController extends Controller
{
    //cho phia front end
    public function AllSliders()
    {
        $sliders = HomeSlider::all();
        return $sliders;
    }

    //cho phia admin
    public function GetAllSlider()
    {
        $slider = HomeSlider::latest()->get();
        return view('backend.slider.slider_view', compact('slider'));
    } // End Mehtod


    public function AddSlider()
    {

        return view('backend.slider.slider_add');
    }

    public function StoreSlider(Request $request)
    {

        $request->validate([
            'slider_image' => 'required',
        ], [
            'slider_image.required' => 'Upload Slider Image'

        ]);

        $image = $request->file('slider_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(1024, 379)->save('upload/slider/' . $name_gen);
        $save_url = 'http://127.0.0.1:8000/upload/slider/' . $name_gen;

        HomeSlider::insert([
            'slide_img' => $save_url,
        ]);

        $notification = array(
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.slider')->with($notification);
    }

    public function EditSlider($id)
    {
        $slider = HomeSlider::findOrFail($id);
        return view('backend.slider.slider_edit', compact('slider'));
    } // End Mehtod


    public function UpdateSlider(Request $request)
    {

        $slider_id = $request->id;

        $image = $request->file('slider_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(1024, 379)->save('upload/slider/' . $name_gen);
        $save_url = 'http://127.0.0.1:8000/upload/slider/' . $name_gen;

        HomeSlider::findOrFail($slider_id)->update([
            'slide_img' => $save_url,
        ]);

        $notification = array(
            'message' => 'Slider Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.slider')->with($notification);
    } // End Mehtod

    public function DeleteSlider($id)
    {

        HomeSlider::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Slider Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Mehtod

}
