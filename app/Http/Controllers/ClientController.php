<?php
namespace App\Http\Controllers;

use App\Http\Requests\ClientsStoreRequest;
use App\Http\Requests\ClientsUpdateRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Traits\HandlesOptimizedMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    use HandlesOptimizedMedia;

    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        // $this->middleware('permission:client_create')->only(['store']);
        // $this->middleware('permission:client_update')->only(['update']);
        // $this->middleware('permission:client_delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $client = Client::with('projects')->paginate(getPerPage($request));

        return ClientResource::collection($client);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show(int $id)
    {
        $client = Client::with('projects')->findOrFail($id);

        return new ClientResource($client);
    }

    public function store(ClientsStoreRequest $request)
    {
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, $request, &$clients) {

                $clients = Client::create($data);

                if ($request->hasFile('logo')) {

                    $file = $request->file('logo');

                    $this->addOptimizedMedia($clients, $file, 'logo');
                }

                return $clients;
            });

            return backWithSuccess(
                data: new ClientResource($clients)
            );
        } catch (\Exception $e) {
            return backWithError($e);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientsUpdateRequest $request, int $id)
    {
        $client = Client::findOrFail($id);
        $data   = $request->validated();

        try {

            DB::transaction(function () use ($data, $client, $request) {

                $client->update($data);

                // 🔥 handle logo update
                if ($request->hasFile('logo')) {

                    // امسح القديم
                    $client->clearMediaCollection('logo');

                    // ارفع الجديد
                    $this->addOptimizedMedia(
                        $client,
                        $request->file('logo'),
                        'logo'
                    );
                }
            });

            return backWithSuccess(
                data: new ClientResource($client->load('projects'))
            );

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $client = Client::findOrFail($id);

        try {
            $client->clearMediaCollection('logo');

            $client->delete();

            return backWithSuccess();

        } catch (\Exception $e) {
            return backWithError($e);
        }
    }
}
