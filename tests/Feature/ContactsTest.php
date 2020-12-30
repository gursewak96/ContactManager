<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Contact;
use Carbon\Carbon;
use App\User;

class ContactsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     private $user;

     public function setUp(): void
     {
         parent::setUp();
         $this->user = factory(User::class)->create();
         
     }

     public function test_a_list_of_contact_can_be_fetched_for_an_authenticated_user()
     {
         $user = factory(User::class)->create();
         $anotherUser = factory(User::class)->create();

         $contact = factory(Contact::class)->create(['user_id'=>$user->id]);
         $anotherContact = factory(Contact::class)->create(['user_id'=>$anotherUser->id]);

         $response = $this->get('/api/contacts?api_token='.$user->api_token);

         $response->assertJsonCount(1)
                ->assertJson([
                    'data'=>[
                        [
                            'data'=>[
                                "contact_id"=>$contact->id
                                ]
                        ]
                    ]
                ]);
     }

     public function test_an_unauthenticated_user_should_redirected_to_login()
     {

        $response = $this->post('/api/contacts',array_merge($this->data(),['api_token'=>""]));
        $response->assertRedirect('/login');
        $this->assertCount(0, Contact::all());

     }


    public function test_an_authenticated_user_can_add_a_contact()
    {
        $response = $this->post('/api/contacts',array_merge($this->data(),['user_id'=>$this->user->id]));

        $contact = Contact::first();
       
        $this->assertEquals('Test name',$contact->name);
        $this->assertEquals('abc@gmail.com',$contact->email);
        $this->assertEquals('11/02/2001',$contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC Company', $contact->company);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data'=>[
                'contact_id'=>$contact->id
            ],
            'links'=>[
                'self'=>$contact->path()
            ]
        ]);
    }

    public function test_fields_are_required()
    {
        collect(['name','email','birthday','company'])
        ->each(function($field){

            $response = $this->post('/api/contacts',array_merge($this->data(),[$field=>'']));

            $response->assertSessionHasErrors($field);
            $this->assertCount(0, Contact::all());
        });

    }

    public function test_email_must_be_valid_email()
    {
        $response = $this->post('/api/contacts',array_merge($this->data(),['email'=>'Not a valid email']));

        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Contact::all());

    }

    public function test_birthdays_are_properly_formatted()
    {
        $response = $this->post('/api/contacts',array_merge($this->data()));
        $this->assertCount(1, Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
        $this->assertEquals("11-02-2001", Contact::first()->birthday->format('m-d-Y'));

    }

    public function test_a_single_contact_can_be_retrieved()
    {
        $contact = factory(Contact::class)->create(['user_id'=>$this->user->id]);
        $response = $this->get('/api/contacts/'.$contact->id. "?api_token=".$this->user->api_token);

        // dd(json_decode($response->getContent()));
        $response->assertStatus(200)
            ->assertJson([
                'data'=>[
                    'contact_id'=>$contact->id,
                    'name'=>$contact->name,
                    'email' => $contact->email,
                    'birthday'=>$contact->birthday->format('m/d/Y'),
                    'company' => $contact->company,
                ]
            ]);;
    }

    public function test_only_the_user_contact_can_be_retrieved()
    {
        $contact = factory(Contact::class)->create(['user_id'=>$this->user->id]);

        $anotherUser = factory(User::class)->create();
        $response = $this->get('/api/contacts/'.$contact->id. "?api_token=".$anotherUser->api_token);

        $response->assertStatus(403);
    }

    public function test_a_contact_can_be_patched()
    {
        $contact = factory(Contact::class)->create(['user_id'=>$this->user->id]);

        $response = $this->patch("/api/contacts/".$contact->id, $this->data());

        $contact = $contact->fresh();

        $this->assertEquals('Test name',$contact->name);
        $this->assertEquals('abc@gmail.com',$contact->email);
        $this->assertEquals('11/02/2001',$contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC Company', $contact->company);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data'=>[
                'contact_id'=>$contact->id
            ],
            'links'=>[
                'self'=>$contact->path()
            ]
        ]);

    }

    public function test_only_the_owner_of_the_contact_can_patch_the_contact()
    {
        $contact = factory(Contact::Class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->patch("/api/contacts/".$contact->id, array_merge($this->data(), ['api_token'=>$anotherUser->api_token]));

        $response->assertStatus(403);
    }

    public function test_a_contact_can_be_deleted()
    {
        $contact = factory(Contact::class)->create(['user_id'=>$this->user->id]);

        $response = $this->delete("/api/contacts/".$contact->id, ['api_token'=>$this->user->api_token]);

        $this->assertCount(0, Contact::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);

    }

    public function test_only_the_owner_can_delete_a_contact()
    {
        $contact = factory(Contact::class)->create();

        $anotherUser  = factory(User::class)->create();
        $response = $this->delete("/api/contacts/".$contact->id, ['api_token'=>$anotherUser->api_token]);

        $response->assertStatus(403);

    }

    private function data()
    {
        return [
            'name'=>'Test name',
            'email'=>'abc@gmail.com',
            'birthday'=>"11/02/2001",
            'company'=>"ABC Company",
            "api_token"=> $this->user->api_token
        ];
    }
    
}
