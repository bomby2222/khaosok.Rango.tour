<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', 'about_image', 'popup_video_file']);

        // 1. บันทึกค่าข้อความทั่วไป
        foreach ($inputs as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // บันทึกสถานะเปิด/ปิด Video Popup
        Setting::updateOrCreate(
            ['key' => 'popup_video_status'],
            ['value' => $request->has('popup_video_status') ? '1' : '0']
        );

        // 2. จัดการอัปโหลดรูปภาพหน้า About Us
        if ($request->hasFile('about_image')) {
            $request->validate([
                'about_image' => 'image|mimes:jpeg,png,jpg,webp|max:5120'
            ]);

            $oldImage = Setting::where('key', 'about_image')->value('value');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            $path = $request->file('about_image')->store('about', 'public');
            Setting::updateOrCreate(['key' => 'about_image'], ['value' => $path]);
        }

        // 3. จัดการอัปโหลดไฟล์วิดีโอสำหรับป๊อปอัปหน้าแรก (สูงสุด 50MB)
        if ($request->hasFile('popup_video_file')) {
            $request->validate([
                'popup_video_file' => 'mimes:mp4,mov,ogg,webm|max:51200'
            ]);

            $oldVideo = Setting::where('key', 'popup_video_file')->value('value');
            if ($oldVideo && Storage::disk('public')->exists($oldVideo)) {
                Storage::disk('public')->delete($oldVideo);
            }

            $videoPath = $request->file('popup_video_file')->store('popups', 'public');
            Setting::updateOrCreate(['key' => 'popup_video_file'], ['value' => $videoPath]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings & Video Popup saved successfully.');
    }
}