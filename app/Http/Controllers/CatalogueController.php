<?php

namespace App\Http\Controllers;

use \App\Models\Etude;
use \App\Models\Source;
use \App\Models\Theme;
use \App\Http\Requests\CatalogueFilterRequest;
use \App\Http\Requests\FormEtudeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CatalogueController extends Controller
{
    public function index () {
            return view('catalogue.index',[
            'etudes' => Etude::with('sources','themes')->paginate(4)
        ]);
    }
    public function create() {
        $etude = new Etude();
        return view('catalogue.create',[
            'etude'=>$etude,
            'sources'=>Source::select('id','name')->get(),
            'themes'=>Theme::select('id','name')->get()
        ]);
    }
    public function store (FormEtudeRequest $request){
        $etude = Etude::create($request->validated());
        $etude-> sources()->sync($request->validated('sources'));
        $etude-> themes()->sync($request->validated('themes'));
        return redirect()->route('catalogue.find',['slug'=> $etude->slug, 'etude'=>$etude->id])->with('success',"L'étude a bien été répertoriée");
    }

    public function edit(Etude $etude) {
        return view('catalogue.edit',[
            'etude'=>$etude,
            'sources'=>Source::select('id','name')->get(),
            'themes'=>Theme::select('id','name')->get(),
            'liens' => $etude->liens()->orderBy('position')->get()
        ]);
    }

    public function find(string $slug, Etude $etude) {
        if($etude->slug !== $slug) {

            return to_route('catalogue.find',['slug'=>$etude->slug,'id'=>$etude->id]);
        }

        return view('catalogue.find', [
            'etude'=>$etude
        ]);
    } 

    public function update(Etude $etude, FormEtudeRequest $request) {
        $etude-> update($request->validated());
        $etude-> sources()->sync($request->validated('sources'));
        $etude-> themes()->sync($request->validated('themes'));

        $etude->liens()->delete();

        foreach ($request->link_name as $index => $linkName) {
            $etude->liens()->create([
                'link_name' => $linkName,
                'link_url' => $request->link_url[$index],
                'position' => $index + 1,
            ]);
        }

        return redirect()->route('catalogue.find',['slug'=> $etude->slug, 'etude'=>$etude->id])->with('success',"L'étude a bien été modifiée");
    } 
}
