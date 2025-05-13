<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::paginate(20);
        return view('pages.locations.index', compact('locations'));
    }
    public function create()
    {
        return view('pages.locations.create');
    }
    public function store(Request $request)
    {
        Location::create($request->validate(['name'=>'required','latitude'=>'nullable|numeric','longitude'=>'nullable|numeric','user_id'=>'nullable|exists:users,id']));
        return redirect()->route('pages.locations.index')->with('success','Location created successfully.');
    }
    public function edit(Location $location)
    {
        return view('pages.locations.edit', compact('location'));
    }
    public function update(Request $request, Location $location)
    {
        $location->update($request->validate(['name'=>'required','latitude'=>'nullable|numeric','longitude'=>'nullable|numeric','user_id'=>'nullable|exists:users,id']));
        return redirect()->route('pages.locations.index')->with('success','Location updated successfully.');
    }
    public function destroy(Location $location)
    {
        $location->delete();
        return back()->with('success','Location deleted successfully.');
    }
}
