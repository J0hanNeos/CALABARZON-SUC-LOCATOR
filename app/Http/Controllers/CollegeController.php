<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollegeRequest;
use App\Models\College;
use Illuminate\Http\UploadedFile;

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


        return redirect('/sucs')->with('success', 'SUC added successfully!');
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

        $sucs = College::query()->find($id);
        $avatar = $request->file('avatar');

        if($avatar !== null){
            $updatedFileName = $this->resolveAvatarUrl($avatar);
            $avatar->storeAs("public/images", $updatedFileName);
        }

        $updatedFileName = $avatar !== null ? $updatedFileName : $sucs->avatar_url;

        $sucs->update([
            //id is automatically generated
            'name' => $request->name,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'website' => $request->website,
            'avatar_url'=> $updatedFileName
            //timestamps are automatically generated
        ]);

        return redirect()->back()->with('success', 'SUC updated successfully!');

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
