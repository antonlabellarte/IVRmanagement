<?php

namespace App\Http\Controllers;

use App\Models\Campaigns;
use App\Models\Services;
use App\Models\CustomersList;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    public function index(){
        // $campaigns = CustomersList::paginate(10);
        $campaigns = Campaigns::all();

        return view('campaigns.index', compact('campaigns'));

        // return view('campaigns.index', compact('campaigns'));
    }

    public function create(){
        $queues = Services::all();
        return view('campaigns.add', compact('queues'));
    }

    
    public function store(Request $request){
        $rule = new Campaigns();

        $rule->testo = $request->input('testo');
        $rule->coda = $request->input('coda');
        $rule->forzaCoda = $request->input('forzaCoda');
        $rule->abbattimento = $request->boolean('abbattimento'); // Laravel lo gestisce per te
        $rule->nomeCampagna = $request->input('nomeCampagna');
        $rule->dataInizio = $request->input('dataInizio');
        $rule->dataFine = $request->input('dataFine');
        $rule->allCustomer = $request->boolean('allCustomer');
        $rule->enabled = $request->boolean('enabled');

        $rule->save();

        return redirect()->route('campaigns.index')->with('success', 'Coda inserita');
    }

    
    public function edit(string $id){
        $rule = Campaigns::find($id);

        $queues = Services::all();

        return view('campaigns.edit', compact('rule', 'queues'));
    }

    
    public function update(Request $request, string $id){
        //
    }

    
    public function destroy(string $id){
        $campaignrule = Campaigns::find($id);
        $campaignrule->delete();
        
        return back()->with('erased', 'Campaign rule deleted');
    }

    public function details(string $id)
    {
        $rule = Campaigns::find($id);

        // Recupera tutte le liste collegate a questa regola
        $listsPerRule = CustomersList::where('regoleid', $id)->get();

        // Passa sia la regola che le liste alla view
        return view('campaigns.details', compact('rule', 'listsPerRule'));
}

}
