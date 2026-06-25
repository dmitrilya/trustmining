<?php

namespace App\Http\Controllers\Morph;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Http\Traits\ViewTrait;

class ViewController extends Controller
{
    use ViewTrait;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'viewable_type' => 'required|string',
            'viewable_id'   => 'required|integer',
            'ad_id'         => 'nullable|integer',
        ]);

        $modelClass = Relation::getMorphedModel($request->viewable_type) ?? $request->viewable_type;

        if (!class_exists($modelClass) || !is_subclass_of($modelClass, \Illuminate\Database\Eloquent\Model::class))
            return response()->json(['success' => false, 'message' => 'Invalid model type'], 422);

        try {
            $model = $modelClass::findOrFail($request->viewable_id);

            $view = $this->addView($request, $model, $request->ad_id);

            return response()->json(['success' => true]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Entity not found'], 404);
        }
    }
}
