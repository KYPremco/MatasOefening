<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssemblyResource;
use App\Http\Resources\ComponentResource;
use App\Models\Assembly;
use App\Models\Component;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    /**
     * Gives a filtered list of components & assemblies based on search name
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $search = $request->get("search");

        return Inertia::render('Search/Search', [
            "components" => ComponentResource::collection(Component::filterName($search)->get()),
            "assemblies" => AssemblyResource::collection(Assembly::with('manufacturer')
                ->filterName($search)
                ->get())
        ]);
    }
}
