<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\ViewTrait;

use App\Models\Guide;

class GuideController extends Controller
{
    use ViewTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('guide.index', ['guides' => Guide::orderByDesc('likes')->paginate(20)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function show(Guide $guide)
    {
        $this->addView(request(), $guide);

        return view('guide.show', compact('guide'));
    }
}
