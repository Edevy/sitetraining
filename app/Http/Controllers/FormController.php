<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Concat;

class FormController extends Controller
{

    /**
     * 
     * Fonction pour ajouter les données dans la base de données
     * 
     * 
     */
    function save(Request $request){
        $request->validate(
        [          
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:contacts',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|numeric'
        ]);

        $datas = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip
        ];
        try {
            Contact::create($datas);
            $mess = "Ajouté avec succès";
            return view('/welcome', compact('mess'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
