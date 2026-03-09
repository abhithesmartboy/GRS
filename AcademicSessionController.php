<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use Illuminate\Http\Request;

class AcademicSessionController extends Controller
{
    public function index()
    {
        //
        $data = AcademicSession::all();

        return view('admin.session', compact('data'));
    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starting_date' => 'required|date',
            'ending_date' => 'required|date|after_or_equal:starting_date',
        ]);

        AcademicSession::create([
            'name' => $request->name,
            'description' => $request->description,
            'starting_date' => $request->starting_date,
            'ending_date' => $request->ending_date,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Session added successfully');
    }

    public function edit($id)
    {
        //
        $session = AcademicSession::findOrFail($id);

        return view('admin.session_edit', compact('session'));
    }

    public function update(Request $request, $id)
    {
        //
        $session = AcademicSession::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starting_date' => 'required|date',
            'ending_date' => 'required|date|after_or_equal:starting_date',
        ]);

        $session->update([
            'name' => $request->name,
            'description' => $request->description,
            'starting_date' => $request->starting_date,
            'ending_date' => $request->ending_date,
        ]);

        return redirect('/admin/session')->with('success', 'Session updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        //
        AcademicSession::findOrFail($request->id)->delete();

        return redirect()->back()->with('success', 'Session deleted successfully');
    }
}
