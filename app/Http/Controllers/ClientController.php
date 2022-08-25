<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();

        return response()->json([
            'success' => true,
            'data' => $clients
        ],200);
    }
    public function show($id)
    {
        $clients=Client::find($id);

        if (!$clients) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found '
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $clients
        ], 200);
    }

    public function store(Request $request)
    {
        $client=Client::create($request->all());
        if ($client)
            return response()->json([
                'success' => true,
                'data' => $client
            ],200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Client not added'
            ], 400);
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found'
            ], 404);
        }

        $updated = $client->update($request->all());

        if ($updated)
            return response()->json([
                'success' => true,
                'data'=>$updated
            ],200);
        else
            return response()->json([
                'success' => false,
                'message' => 'Client can not be updated'
            ], 400);
    }

    public function destroy($id)
    {
        $client=Client::find($id);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client not found'
            ], 404);
        }

        if ($client->delete()) {
            return response()->json([
                'success' => true,
                'message'=> 'Client deleted successfully'
            ],200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Client can not be deleted'
            ], 400);
        }
    }
}
