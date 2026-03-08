<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use App\Models\Setting;
use App\Traits\HandlesOptimizedMedia;
;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:settings_update')->only(['update']);
    }
    use HandlesOptimizedMedia;
    public function update(SettingsRequest $request)
    {
        $data = $request->validated();
        try {

            $setting = Setting::firstOrCreate([]);
            
            $setting->update($data);

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');


                $setting->clearMediaCollection('logo');

                $this->addOptimizedMedia($setting, $file, 'logo');

            }

            return backWithSuccess();
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}

