<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Concat;
use Illuminate\Support\Facades\Validator;

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

    function showForm(){
        return view('another_form');
    }

    /***
     * 
     * 
     * Fonction sauvegarder avec JQuery
     */
    function saveJquery(Request $req){
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:contacts',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|numeric'
        ];

        $validate = Validator::make($req->all(), $rules);

        if($validate->fails()){
            return response()->json([
                'warning'=>$validate->errors()
            ]);
        }

        $datas = [
            'firstname' => $req->firstname,
            'lastname' => $req->lastname,
            'username' => $req->username,
            'city' => $req->city,
            'state' => $req->state,
            'zip' => $req->zip
        ];

        try {
            Contact::create($datas);
            return response()->json([
                'success'=>[
                    'status'=>'success',
                    'message'=>'Data added with status success'
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error'=>$th->getMessage()
            ]);
        }

     
    }
}
