<?php

namespace App\Http\Controllers;

use App\Http\Requests\NurseStoreRequest;
use App\Http\Requests\NurseUpdateRequest;
use App\Http\Resources\NurseCollection;
use App\Http\Resources\NurseResource;
use App\Models\Nurse;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\NurseCollection
     */
    public function index(Request $request)
    {
        $nurses = Nurse::all();

        return view('nurses.index', ['nurses' => $nurses]);

        // return new NurseCollection($nurses);
    }

    /**
     * @param \App\Http\Requests\NurseControllerStoreRequest $request
     * @return \App\Http\Resources\NurseResource
     */
    public function store(NurseStoreRequest $request)
    {
        $nurse = Nurse::create($request->validated());

        return new NurseResource($nurse);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Nurse $nurse
     * @return \App\Http\Resources\NurseResource
     */
    public function show(Request $request, Nurse $nurse)
    {
        return new NurseResource($nurse);
    }

    /**
     * @param \App\Http\Requests\NurseControllerUpdateRequest $request
     * @param \App\Models\Nurse $nurse
     * @return \App\Http\Resources\NurseResource
     */
    public function update(NurseUpdateRequest $request, Nurse $nurse)
    {
        $nurse->update($request->validated());

        return new NurseResource($nurse);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Nurse $nurse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Nurse $nurse)
    {
        $nurse->delete();

        return response()->noContent();
    }
}
