<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class TagsController extends Controller
{
    /**
     * TagsController constructor.
     */
    public function __construct()
    {
       $this->middleware('auth')->except(['articles']);
    }

    /**
     * Index articles of tag
     *
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articles(Tag $tag)
    {
        $articles = $tag->articles()
            ->latest()
            ->simplePaginate(10);

        return view('home', compact('articles'));
    }

    /**
     * Tags index
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function index()
    {
        if(Gate::denies('index', Tag::class))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }
        
        $tags = Tag::paginate(20);
        
        return view('tags.index', compact('tags'));
    }

    /**
     * Create tag
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function create()
    {
        if(Gate::denies('create', Tag::class))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }

        return view('tags.create');
    }

    /**
     * Store tag
     *
     * @param TagRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function store(TagRequest $request)
    {
        if(Gate::denies('create', Tag::class))
        {
            throw new AuthorizationException('You are not authorized for this action');
        }

        Tag::create([
           'name' => $request->get('name')
        ]);
        
        return redirect()->route('tag.index');
    }
}