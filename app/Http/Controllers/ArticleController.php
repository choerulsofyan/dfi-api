<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::select('id', 'title', 'content', 'created_at')->orderBy('created_at', 'DESC')->get();

        foreach ($articles as $key => $value) {

            $created_at = $value['created_at']->format('d F Y H.i');
            unset($articles[$key]['created_at']);
            $articles[$key]['date'] = $created_at;
            $articles[$key]['content'] = str_limit($value['content'], 100);
        }

        $data = array("status" => 200, "results" => $articles);

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
            'title' => 'required|string|unique:articles',
            'content' => 'required|string'
        ]);

        $article = Article::firstOrCreate([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::select('id', 'title', 'content', 'created_at')->find($id);

        $created_at = $article->created_at->format('d F Y H.i');
        unset($article->created_at);
        $article->date = $created_at;

        $data = array("status" => 200, "results" => $article);

        return response()->json($data);
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
            'title' => 'required|string|unique:articles,title,' . $id,
            'content' => 'required|string'
        ]);

        $article = Article::findOrFail($id);

        $article->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Article::findOrFail($id)->delete();
        return response()->json('Article deleted successfully');
    }
}
