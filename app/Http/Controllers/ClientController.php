<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientsRequest;
use App\Http\Requests\UpdateClientsRequest;
use App\Http\Resources\ClientResources;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('permission:client_show')->only(['index', 'show']);
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
    public function store(StoreClientsRequest $request)
    {
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, $request) {

                $client = Client::create($data);

                if ($request->hasFile('logo')) {
                    
                    $file = $request->file('logo');

                    $client->addOptimizedMedia($client, $file, 'logo');
                }

                return new ClientResources($client);
            });
        } catch (\Exception $e) {
            backWithError($e);
        }

    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientsRequest $request, string $id)
    {
        $client = Client::findOrFail($id);
        $data = $request->validated();

        try {

            DB::transaction(function () use ($data, $client) {
                $client->update($data);

                return new ClientResources($client);
            });
        } catch (\Exception $e) {
            backWithError($e);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
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
