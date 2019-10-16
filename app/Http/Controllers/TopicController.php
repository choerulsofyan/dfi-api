<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::select('id', 'name', 'description', 'created_at')->orderBy('name', 'ASC')->get();
        $data = array("status" => 200, "results" => $topics);
        return response()->json($data);
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
            'name' => 'required|string|unique:topics',
            'description' => 'required|string'
        ]);

        $topic = Topic::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json($topic, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Topic::find($id);
        return response()->json($topic);
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
            'name' => 'required|string|unique:topics,name,' . $id,
            'description' => 'required|string'
        ]);

        $topic = Topic::find($id);

        $topic->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json($topic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Topic::find($id)->delete();
        return response()->json('Topic deleted successfully');
    }

    /**
     * Display the comments of a post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function articles($id)
    {
        $comments = Topic::find($id)->articles()->select('id', 'title', 'content', 'created_at')->orderBy('created_at', 'DESC')->get();

        foreach ($comments as $key => $value) {
            $created_at = $value['created_at']->format('d F Y');
            unset($comments[$key]['created_at']);
            $comments[$key]['date'] = $created_at;
        }

        $data = array("status" => 200, "results" => $comments);

        return response()->json($data);
    }
}
