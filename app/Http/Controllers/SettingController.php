<?php
namespace App\Http\Controllers;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::firstOrCreate([]); // will auto-create empty row if none exists
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'institute_name' => 'required|string|max:255',
            'institute_address' => 'nullable|string|max:500',
            'institute_email' => 'nullable|email|max:255',
            'institute_phone' => 'nullable|string|max:20',
            'institute_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $setting = Setting::firstOrCreate([]);

        // Upload logo if present
        if ($request->hasFile('institute_logo')) {
            $file = $request->file('institute_logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $setting->institute_logo = $filename;
        }

        $setting->institute_name = $request->institute_name;
        $setting->institute_address = $request->institute_address;
        $setting->institute_email = $request->institute_email;
        $setting->institute_phone = $request->institute_phone;

        $setting->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}

