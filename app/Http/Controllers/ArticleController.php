<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     /*******GLOBAL SCOPE USED*************
     *in article model global scope written to app where() condition to all functions.
     app\Models\Article.php - global scope code writtien
     */
    public function index()
    {   

        $articles = Article::with('user')->get();

        return view('articles.index', compact('articles'));
        
       // return response()->json($articles);
       // I tried to send api json structure to check global scope and it is working no problem.
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $organizationId = auth()->user()->organization_id ? auth()->user()->organization_id : auth()->id(); // if there is organization id get organization id otherwise get user id.
        Article::create($request->all()+
           [
               'user_id'=>$organizationId, 
               'published_at'=>Gate::allows('publish-articles')  // here we allow to add published date for admin and publisher only. User can not add.
                               && $request->input('published') ? now() :null
            
               ]);

        return redirect()->route('articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */

    public function edit(Article $article)
    {   
        // for more information check the link = https://laravel.com/docs/8.x/authorization#via-controller-helpers
        //via controller helper code like below we check the user authorize or not.
        // This is policy issue https://laravel.com/docs/8.x/authorization#creating-policies
        //We created policy for article  app\Policies\ArticlePolicy.php // there we define the actions. For instance we define user can update only own article in update function.
        // For view the article we define in app\Policies\ArticlePolicy.php // user can view only own article.
        // So policy is very good solution to manage contoller authorization.Also it is working with api.
        $this->authorize('update', $article); // policy code.

        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $data=$request->all();
        
        if(Gate::allows('publish-articles')){
            $data['published_at']= $request->input('published') ? now() : null;
            
        }
        $article->update($data);
        
        return redirect()->route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('update', $article);
        $article->delete();
        return redirect()->route('articles.index');
    }
}
