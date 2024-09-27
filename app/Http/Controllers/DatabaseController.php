<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Traits\ViewTrait;

use App\Models\AsicBrand;
use App\Models\AsicModel;
use App\Models\AsicVersion;

class DatabaseController extends Controller
{
    use ViewTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('database.index', [
            'brands' => AsicBrand::all()->reverse(),
            'popularModels' => AsicModel::with('asicBrand')->withCount('views')->orderBy('views_count', 'desc')->limit(8)->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\AsicBrand  $asicBrand
     * @return \Illuminate\Http\Response
     */
    public function brand(AsicBrand $asicBrand)
    {
        return view('database.brand', ['brand' => $asicBrand, 'models' => $asicBrand->asicModels()->withCount('views')->get()->reverse()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AsicBrand  $asicBrand
     * @param  \App\Models\AsicModel  $asicModel
     * @return \Illuminate\Http\Response
     */
    public function model(AsicBrand $asicBrand, AsicModel $asicModel)
    {
        $this->addView(request(), $asicModel);

        return view('database.model', ['brand' => $asicBrand, 'model' => $asicModel, 'versions' => $asicModel->asicVersions]);
    }

    public function reviews(AsicBrand $asicBrand, AsicModel $asicModel)
    {
        return view('review.index', [
            'auth' => \Auth::user(),
            'name' => $asicModel->name,
            'type' => 'App\Models\AsicModel',
            'id' => $asicModel->id,
            'reviews' => $asicModel->reviews
        ]);
    }
}
