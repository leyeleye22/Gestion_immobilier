<?php

namespace App\Http\Controllers;

use App\Models\bien;
use App\Models\commentaire;
use function Ramsey\Uuid\v1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Request;
// use App\Http\Requests\Request;

class BienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexfirst()
    {
        $biens = bien::all();
        return view('/admin/dashboard', compact('biens'));
    }
    public function index()
    {
        return view('admin.ajoutbien');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $biens = bien::FindOrFail($request->id);
        $Commentaires = commentaire::where('bien_id', $biens->id)->get();
        return view('admin.voirdetails', compact('biens', 'Commentaires'));
    }
    public function deletes(commentaire $commentaire)
    {
        if ($commentaire->delete()) {
            return redirect('/dashboard/admin');
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $biens = new bien();
        $request->validate(
            [
                'nombien' => 'required|min:2|max:25',
                'categori' => 'required',
                'adresse' => 'required',
                'image' => 'required',
                'description' => 'required',
                'status' => 'required',
            ]
        );

        $biens->nom = $request->nombien;
        $biens->categorie = $request->categori;
        $biens->image = $request->image;
        $biens->description = $request->description;
        $biens->statu = $request->status;
        $biens->adresse = $request->adresse;
        $biens->datePublication = $request->datepub;
        if ($biens->save()) {
            return redirect('/dashboard/admin');
        } else {
            dd('error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(bien $bien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $bien = bien::FindOrFail($request->id);
        return view('admin.Modifierbien', compact('bien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $bien = bien::FindOrFail($request->id);
        $request->validate(
            [
                'nombien' => 'required|min:2|max:25',
                'categori' => 'required',
                'adresse' => 'required',
                'image' => 'required',
                'description' => 'required',
                'status' => 'required',
            ]
        );

        $bien->nom = $request->nombien;
        $bien->categorie = $request->categori;
        $bien->image = $request->image;
        $bien->description = $request->description;
        $bien->statu = $request->status;
        $bien->adresse = $request->adresse;
        $bien->datePublication = $request->datepub;
        if ($bien->save()) {
            return redirect('/dashboard/admin');
        } else {
            dd('error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function showdetailsBien(Request $request){
        $biens = bien::FindOrFail($request->id);
        $Commentaires = commentaire::where('bien_id', $biens->id)->get();
        return view('user.voirdetails', compact('biens', 'Commentaires'));

    }
    public function delete(Request $request)
    {
        $biens = bien::FindOrFail($request->id);
        if ($biens->delete()) {

            return redirect('/dashboard/admin');
        }
    }
}
