<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::orderBy('created_at', 'DESC')->get();
        return response()->json($programs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string|unique:programs',
            'type' => 'required|string',
            'agency' => 'required|string'
        ]);

        $program = Program::firstOrCreate([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'agency' => $request->agency
        ]);

        return response()->json($program, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $program = Program::find($id);
        return response()->json($program);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string|unique:programs,email,' . $id,
            'type' => 'required|string',
            'agency' => 'required|string'
        ]);

        $program = Program::find($id);

        $program->update([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'agency' => $request->agency
        ]);

        return response()->json($program);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Program::find($id)->delete();
        return response()->json('Program deleted successfully');
    }
}
