<?php

namespace App\Http\Controllers;

use App\phonebook;
use Illuminate\Http\Request;
use App\Http\Resources\Phonebook as PhonebookResource;


class PhonebookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get articles
        $phonebook = Phonebook::all();
        // $phonebook = Phonebook::orderBy('created_at', 'desc')->paginate(10);

        // Return collection of articles as a resource
        return PhonebookResource::collection($phonebook);
    }

    public function store(Request $request)
    {
        $phonebook = $request->isMethod('put') ? Phonebook::findOrFail($request->phonebook_id) : new Phonebook;

        $phonebook->id = $request->input('phonebook_id');
        $phonebook->name = $request->input('name');
        $phonebook->phonenumber = $request->input('phonenumber');
        $phonebook->region = $request->input('region');
        $phonebook->address = $request->input('address');

        if($phonebook->save()) {
            return new PhonebookResource($phonebook);
        }
        
    }

    /**
     * Display the specified resource.
     *
     */
     public function show($id)
    {
        // Get article
        $phonebook = Phonebook::findOrFail($id);

        // Return single article as a resource
        return new PhonebookResource($phonebook);
    }

   

    public function destroy($id)
    {
        // Get article
        $phonebook = Phonebook::findOrFail($id);

        if($phonebook->delete()) {
            return new PhonebookResource($phonebook);
        }    
    }
}
