<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Http\Requests\TagRequest;
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
        $this->isAuthorized('index', Tag::class);
        
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
        $this->isAuthorized('create', Tag::class);

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
        $this->isAuthorized('create', Tag::class);

        Tag::create([
           'name' => $request->get('name')
        ]);

        session()->flash('message', 'Tag has been created!');
        
        return redirect()->route('tag.index');
    }

    /**
     * Edit Tag
     *
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function edit(Tag $tag)
    {
        $this->isAuthorized('update', Tag::class);
        
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update Tag
     *
     * @param Tag $tag
     * @param TagRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Tag $tag, TagRequest $request)
    {
        $this->isAuthorized('update', Tag::class);

        $tag->update([
           'name' => $request->get('name')
        ]);

        session()->flash('message', 'Tag has been updated!');

        return redirect()->route('tag.index');
    }

    /**
     * Delete Tag
     *
     * @param Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function delete(Tag $tag)
    {
        $this->isAuthorized('delete', Tag::class);

        $tag->delete();

        session()->flash('message', 'Tag has been deleted!');

        return redirect()->route('tag.index');
    }
}