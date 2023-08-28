<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployerController extends Controller
{
    public function index()
    {
        return view('employer.index');
    }

    public function createJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company' => 'required',
            'email' =>  'required|email',
            'phone' => 'required|numeric|digits:10',
            'location'  =>  'required|min:10',
            'job_title' => 'required',
            'job_description' => 'required',
            'job_type' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return response()->json(['error' => $error], 422);
        }

        Job::create($request->all());

        return response()->json(['success' => 'Added new records.']);
    }
    public function getData()
    {
        $data = Job::all();
        return response()->json($data);
    }


    public function getJobData(Request $request)
    {
        $job = Job::withCount('candidates')->find($request->id);

        return response()->json($job);
    }
    public function getCandidateDetails(Request $request)
    {
        $job = Job::findOrFail($request->id);
        $candidateDetails = $job->candidates->map(function ($candidate) {
            return [
                'email' => $candidate->email,
                'name' => $candidate->name,
                'phone' => $candidate->phone,
                'resume' => $candidate->resume,
                'applied_on' => $candidate->created_at->format('m-d-Y H:i:s')
            ];
        });
        return response()->json($candidateDetails);
    }
}
