<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request):Response
    {
            $validatedData = $request->validated();
            $validatedData['image'] = $request->file('image')->store('image');
            $validatedData['user_id'] = Auth::id();
            $data = Profile::create($validatedData);
            return response($data, Response::HTTP_CREATED);
    }

    /**destroy
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        $request->validated();
        $profile->update($request->all());
        return response($profile, Response::HTTP_ACCEPTED);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response()->json(null);
    }

    public function delete(int $id) {
        $profile = Profile::find($id);
        if(!Auth::user()->is_admin){
            return response('', Response::HTTP_FORBIDDEN);
        }
        $profile?->delete();
        return response()->json(null);
    }
}
