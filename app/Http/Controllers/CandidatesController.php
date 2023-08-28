<?php

namespace App\Http\Controllers;

use App\Mail\JobNotification;
use App\Models\Candidate;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CandidatesController extends Controller
{
    public function index()
    {
        return view('candidates.index');
    }

    public function applyJob(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required',
            'email' =>  'required|email',
            'phone' => 'required|numeric|digits:10',
            'resume' => 'required|mimes:pdf,doc|max:3000',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return response()->json(['error' => $error], 422);
        }

        $resume   = "resumes/" . time() . '_.' . $request->resume->getClientOriginalExtension();
        Storage::disk('public')->put($resume, file_get_contents($request->resume));

        $requestData['resume'] = $resume;

        Candidate::create($requestData);
        $job = Job::find($request->job_id);

        Mail::to($job->email)->queue(new JobNotification($requestData, $job));

        return response()->json(['success' => 'Added new records.']);
    }
}
