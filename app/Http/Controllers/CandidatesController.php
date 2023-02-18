<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Traits\ApiHelperTrait;
use App\Http\Requests\CandidateRequest;

class CandidatesController extends Controller
{

    use ApiHelperTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(isset($request->first_name) && $request->first_name != '' && isset($request->last_name) && $request->last_name != '') {
            $candidate = Candidate::where('first_name', $request->first_name)
                                  ->where('last_name', $request->last_name)
                                  ->paginate(25);
            $candidate->withPath(url()->current().'?first_name=' . $request->first_name . '&last_name=' . $request->last_name);
        } else {
            $candidate = Candidate::paginate(25);
        }

        return $this->sendResponse($candidate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CandidateRequest $request)
    {
        $data = $request->validated();

        if (Candidate::create($data)) {
            return $this->sendResponse($data, 'New Candidate Created');
        } else {
            return $this->sendError('Something Went Wrong', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidate = Candidate::find($id);

        return $this->sendResponse($candidate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
