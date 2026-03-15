<?php

namespace App\Http\Controllers;

use App\Http\Resources\SelectedClientsResources;
use App\Models\Client;

class SelectClientController extends Controller
{
    public function clients()
    {
        $clients = Client::select('id', 'name')->get();

        return SelectedClientsResources::collection($clients);
    }
}
