<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersStoreRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Http\Resources\UsersResources;
use App\Models\User;
use App\Traits\ImageHandlerTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use ImageHandlerTrait;

    public function __construct()
    {
        $this->middleware('permission:user_view')->only(['index', 'show']);
        $this->middleware('permission:user_create')->only(['store']);
        $this->middleware('permission:user_update')->only(['update']);
        $this->middleware('permission:user_delete')->only(['destroy']);
    }

    public function index()
    {
        $users = User::paginate(10);

        return UsersResources::collection($users);
    }

    public function store(UsersStoreRequest $request)
    {
        try {
            $data = $request->validated();

            $user = DB::transaction(function () use ($data, $request) {

                $user = User::create($data);

                // لو فيه صورة
                if ($request->hasFile('images')) {
                    $images = $request->file('images');

                    // Handle both single file and array of files
                    if (!is_array($images)) {
                        $images = [$images];
                    }

                    Log::info('Images found in request, count: ' . count($images));

                    foreach ($images as $key => $image) {
                        Log::info('Processing image ' . ($key + 1) . ': ' . $image->getClientOriginalName());

                        // 1️⃣ تصغير الصورة أولاً باستخدام GD
                        $tempPath = $this->uploadAndCompressImage($image, 'temp', 100, 60);

                        Log::info('Image uploaded to temp path: ' . $tempPath);
                        Log::info('Temp file exists: ' . (file_exists(public_path($tempPath)) ? 'Yes' : 'No'));
                        Log::info('Temp file size: ' . (file_exists(public_path($tempPath)) ? filesize(public_path($tempPath)) / 1024 : 0) . ' KB');

                        if ($tempPath) {
                            Log::info('Adding image to Spatie media collection');
                            // 2️⃣ رفع الصورة لـ Spatie بعد التصغير
                            $user->addMedia(public_path($tempPath))
                                ->toMediaCollection('images');

                            Log::info('Image added to media collection successfully');

                            // 3️⃣ حذف الصورة المؤقتة
                            $this->deleteImage($tempPath);
                            Log::info('Temp file deleted');
                        } else {
                            Log::error('Failed to compress/upload image: ' . $image->getClientOriginalName());
                        }
                    }
                } else {
                    Log::info('No images found in request');
                }

                return $user;
            });

            return UsersResources::make($user);

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
    public function show(User $user)
    {
        return new UsersResources($user);
    }

    public function update(UsersUpdateRequest $request, User $user)
    {
        try {
            $data = $request->validated();

            DB::transaction(function () use ($data, &$user) {
                $user->update($data);
            });


            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
