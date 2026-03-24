<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Traits\HandlesOptimizedMedia;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_setting')->only(['store']);

        $this->middleware('permission:update_setting')->only(['update']);
    }

    use HandlesOptimizedMedia;

    public function index()
    {
        $setting = Setting::first();

        return new SettingResource($setting);
    }

    public function show($id)
    {
        $setting = Setting::findOrFail($id);

        return new SettingResource($setting);
    }

    public function store(SettingsRequest $request)
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

            return backWithSuccess(data: new SettingResource($setting));
        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
