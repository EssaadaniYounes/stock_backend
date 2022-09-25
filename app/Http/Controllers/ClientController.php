<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $clients = DB::table('clients')
            ->join('cities','cities.id','clients.city_id')
            ->selectRaw('clients.*, cities.name as city')
            ->where('clients.company_id','=',$company_id)
            ->get();

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
    public function getBalance($id){
        $company_id=auth()->user()->company_id;
        $balances = DB::table('clients_invoices_items')
            ->join('clients_invoices','clients_invoices.id','=','clients_invoices_items.invoice_id')
            ->join('clients','clients.id','clients_invoices.client_id')
            ->selectRaw('clients_invoices_items.*,
                clients_invoices.invoice_num,
                MONTH(clients_invoices_items.dt) as month,
                DAY(clients_invoices_items.dt) as day
                ')
            ->where([
                ['clients.id','=',$id],
                ['clients.company_id','=',$company_id]
            ])
            ->get();
        $invoices= DB::table('clients_invoices')
            ->join('clients','clients.id','=','clients_invoices.client_id')
            ->selectRaw('clients_invoices.*,
                                  clients.full_name as client_name,
                                  MONTH(clients_invoices.invoice_date) as month,
                                  DAY(clients_invoices.invoice_date) as day
                                  ')
            ->where([
                ['clients.id','=',$id],
                ['clients.company_id','=',$company_id]
            ])
            ->get();
        return response()->json([
            'success'=>true,
            'data'=>$balances,
            'invoices'=>$invoices
        ],200);
    }
    public function store(Request $request)
    {
        $data=$request->all();
        $data['company_id']=auth()->user()->company_id;
        $client=Client::create($data);
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
