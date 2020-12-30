<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Contact;
use App\Http\Resources\Contact as ContactResources;

class ContactsController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny',Contact::class);
        return ContactResources::collection(request()->user()->contacts);
    }


    public function store()
    {
        $this->authorize('create',Contact::class);

        $data = request()->validate($this->validateData());
        $contact = request()->user()->contacts()->create($data);
        return (new ContactResources($contact))->response()->setStatusCode(201);
    }

    public function show(Contact $contact)
    {
        $this->authorize('view',$contact);
        return new ContactResources($contact);
    }

    public function update(Contact $contact)
    {
        $this->authorize('update',$contact);
        $data = request()->validate($this->validateData());
        $contact->update($data);

        return (new ContactResources($contact))
            ->response()
            ->setStatusCode(200);
    }

    public function delete(Contact $contact)
    {
        $this->authorize('delete',$contact);
        $contact->delete();

        return response([],204);
    }

    
    private function validateData()
    {
        return [
            'name' => "required",
            'email'=> "required|email",
            'birthday'=> "required",
            'company' => "required"
        ];
    }
}
