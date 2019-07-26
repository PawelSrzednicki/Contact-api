<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ValidateContactRequest;
use App\Http\Resources\Api\v1\ContactResource;
use App\Http\Resources\Api\v1\ContactResourceCollection;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::where('user_id', Auth::guard('api')->user()->id)->get();

        $data = new ContactResourceCollection($contacts);

        if (!$contacts == 0) {
            return response()->json("no contact for given user", 404);
        }

        return response()->json([
            'data' => $data,
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateContactRequest $request)
    {

        $contact = new Contact($request->all());
        $contact->user_id = Auth::guard('api')->user()->id;
        $contact->save();

        return response()->json([
            'status' => 'success',
            'data' => $contact->id,
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     */
    public function show(Contact $contact)
    {

        $this->authorize('view', $contact);

        return new ContactResource($contact);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->update($request->all());

        return response()->json("updated contact", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return response()->json("deleted contact", 200);
    }
}
