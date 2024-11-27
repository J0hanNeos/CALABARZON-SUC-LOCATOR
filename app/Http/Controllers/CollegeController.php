<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollegeRequest;
use App\Models\College;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class CollegeController extends Controller
{

    public function index()
    {
        $sucs = College::query()->get();
        return view('colleges.index',[
            'sucs' => $sucs
        ]);

    }

    public function show()
    {
        return view('colleges.show');
    }

    public function create()
    {
        return view('colleges.create');
    }

    public function store(CollegeRequest $request)
    {
        $avatar = $request->file('avatar');

        $updatedFileName = null;//$this->resolveAvatarUrl($avatar);

        // $avatar = null;
        if($avatar){
            $updatedFileName = $this->resolveAvatarUrl($avatar);
            $avatar->storeAs("public/images", $updatedFileName);
        }else{
            $updatedFileName = "";
        }

        //Store avatar
        //$avatar->storeAs("public/images", $updatedFileName);

        //dd($avatar);
        // Create the college record
        College::create([
            'name' => $request->name,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'website' => $request->website,
            'avatar_url' => $updatedFileName
        ]);


        return redirect('/colleges')->with('success', 'SUC added successfully!');
    }

    public function edit(string $id)
    {
        $sucs = College::query()->find($id);
        return view('colleges.edit',[
            'sucs' => $sucs
        ]);
    }

    public function update(CollegeRequest $request, string $id)
    {

        $college = College::findOrFail($id);

        // Handle avatar removal
        if ($request->has('remove_avatar') && $request->remove_avatar == 1) {
            // Delete the old image from storage
            if ($college->avatar_url) {
                Storage::delete('public/images/' . $college->avatar_url);
            }

            // Update the avatar field to null
            $college->avatar_url = null;
        }

        // Handle avatar upload if a new file is selected
        if ($request->hasFile('avatar')) {
            // Store new image
            $avatarPath = $request->file('avatar')->store('images', 'public');
            $college->avatar_url = basename($avatarPath);
        }

        // Update other fields
        $college->name = $request->name;
        $college->address = $request->address;
        $college->contact_number = $request->contact_number;
        $college->latitude = $request->latitude;
        $college->longitude = $request->longitude;
        $college->website = $request->website;

        $college->save();

        return redirect()->back()->with('success', 'College details updated successfully');

    }

    public function destroy(string $id)
    {
        College::query()->find($id)->delete();

        return redirect()->back();
    }

    private function resolveAvatarUrl(UploadedFile $avatar)
    {

        $date = now()->unix();
        $originalFilename = pathInfo($avatar->getClientOriginalName(),PATHINFO_FILENAME);

        //construct the filename
        $filename = "$originalFilename-$date";

        $extension = $avatar->getClientOriginalExtension();
        $updatedFileName = "$filename.$extension";

        return $updatedFileName;

    }
}
