<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientsStoreRequest;
use App\Http\Requests\ClientsUpdateRequest;
use App\Http\Resources\ClientResources;
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
        $this->middleware('permission:client_create')->only(['store']);
        $this->middleware('permission:client_update')->only(['update']);
        $this->middleware('permission:client_delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $client = Client::with('projects')->paginate(getPerPage($request));

        return ClientResources::collection($client);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show(int $id)
    {
        $client = Client::with('projects')->findOrFail($id);

        return new ClientResources($client);
    }

    public function store(ClientsStoreRequest $request)
    {
        $data = $request->validated();
        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        try {

            DB::transaction(function () use ($data, $request, $roles, &$clients) {

                $clients = Client::create($data);

                if (!empty($roles)) {
                    $clients->roles()->sync($roles);
                }

                if ($request->hasFile('logo')) {

                    $file = $request->file('logo');

                    $this->addOptimizedMedia($clients, $file, 'logo');
                }

                return $clients;
            });

            return backWithSuccess(
                data: new ClientResources($clients)
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
        $data = $request->validated();
        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        try {

            DB::transaction(function () use ($data, $client, $roles) {
                $client->update($data);

                if (!empty($roles)) {
                    $client->roles()->sync($roles);
                } else {
                    $client->roles()->detach();
                }
            });

            return backWithSuccess(
                data: new ClientResources($client)
            );
        } catch (\Exception $e) {
            backWithError($e);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $client = Client::findOrFail($id);

        try {
            $client->delete();

            return backWithSuccess();
        } catch (\Exception $e) {
            backWithError($e);
        }
    }
}
