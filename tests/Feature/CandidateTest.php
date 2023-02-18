<?php

namespace Tests\Feature;

use App\Models\Candidate;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidateTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::create([
            'name' => 'test',
            'email' => rand(12345, 678910) . 'test@gmail.com',
            'password' => \Hash::make('secret1234'),
        ]);

        if (!auth()->attempt(['email' => $user->email, 'password' => 'secret1234'])) {
            return response(['message' => 'Login credentials are invaild']);
        }

        return auth()->user()->createToken('authToken')->accessToken;
        // \Log::info(1, [$res]);
        
        // die;
    }

    public function test_check_login() {
        $user = User::create([
            'name' => 'sample',
            'email' => 'sample@test.com',
            'password' => bcrypt('sample123'),
        ]);


        $loginData = ['email' => 'sample@test.com', 'password' => 'sample123'];

        $response = $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200);

        //Write the response in laravel.log
        // \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);

        // Receive our token
        $this->assertArrayHasKey('token', $response->json());
    }
    
    public function testCandidate() {
        $token = $this->authenticate();

        // Create Candidate

        $data =
            array(
                'first_name' => 'Isabelle Shaffer',
                'last_name' => 'Isabelle Shaffer',
                'email' => 'milym@mailinator.com',
                'contact_number' => '4',
                'gender' => '1',
                'specialization' => 'Computer Science',
                'work_ex_year' => '2',
                'candidate_dob' => '1997-09-24',
                'address' => 'bangalore',
            );

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('api/candidates', $data);

        // $this->insert_id = DB::getPdo()->lastInsertId();

        // $response->dumpHeaders();
        // $response->dumpSession();
        // $response->dump();
        // exit;

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'New Candidate Created'
        ]);
        
        // Fetch All Candidates

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('api/candidates');

        // \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response->json());

        // Fetch One Candidate

        $candidate = Candidate::first();

        // \Log::info(1, [$candidate]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('api/candidates/'. $candidate->id);

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response->json());
    }
}
