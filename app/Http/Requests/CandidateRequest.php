<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = request()->route()->parameter('id');

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:candidates,email,' . $id,
            'contact_number' => 'required|numeric',
            'gender' => 'required|numeric|in:1,2',
            'specialization' => 'required',
            'work_ex_year' => 'required|numeric',
            'candidate_dob' => 'required|date_format:Y-m-d',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'email.required' => 'Email id is required',
            'email.email' => 'Invalid Email Id',
            'email.unique' => 'This Email Id is already registered with candidates',
            'contact_number.required' => 'Contact Number. is required',
            'contact_number.numeric' => 'Contact Number. should be number only',
            'gender.required' => 'Gender is required',
            'gender.numeric' => 'Gender should be number only',
            'gender.in' => 'Gender should be 1 or 2',
            'specialization.required' => 'Specialization is required',
            'work_ex_year.required' => 'Work experience is required',
            'work_ex_year.numeric' => 'Work experience should be number only',
            'candidate_dob.required' => 'Candidate DOB is required',
            'candidate_dob.date_format' => 'Candidate DOB should be Y-m-d format',
            'address.required' => 'Address is required',
        ];
    }
}
