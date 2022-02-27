<?php

namespace App\Http\Controllers;

use App\Events\JobCreated;
use App\Models\Job;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // add role validation for manager
        if($this->user->hasRole('manager')){
            $jobs = Job::all();

            return response()->json([
                'success' => true,
                'message' => 'job created successfully',
                'error' => null,
                'data' => $jobs
            ], Response::HTTP_OK);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'job created successfully',
                'error' => null,
                'data' =>  $this->user->jobs()->get()
            ], Response::HTTP_OK);
        }
        
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
    public function store(Request $request)
    {
        $data = $request->only('title', 'description');

        $validator = Validator::make($data, [
            'title' => 'required|max:100',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => true,
                'message' => 'job created successfully',
                'error' => $validator->messages(),
                'data' => null
            ], 200);
        }

        //Request is valid, create new job
        $job = $this->user->jobs()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // notify the manager
        JobCreated::dispatch($job);

        return response()->json([
            'success' => true,
            'message' => 'job created successfully',
            'error' => null,
            'data' => $job
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
    }
}
