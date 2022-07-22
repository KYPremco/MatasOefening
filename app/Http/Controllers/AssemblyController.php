<?php

namespace App\Http\Controllers;

use App\Http\Requests\Component\CreateComponentRequest;
use App\Http\Requests\Component\UpdateComponentRequest;
use App\Http\Resources\AssemblyResource;
use App\Models\Assembly;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AssemblyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->get("search");

        return Inertia::render('Assembly/AssemblyIndex', [
            "search" => $search,
            "assemblies" => AssemblyResource::collection(Assembly::with('manufacturer')
                ->filterName($search)
                ->get())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Assembly/AssemblyCreate', [
            "manufacturers" => Manufacturer::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateComponentRequest  $createAssemblyRequest
     * @return RedirectResponse
     */
    public function store(CreateComponentRequest $createAssemblyRequest)
    {
        $imagePath = $createAssemblyRequest->file('image')->store('images/assemblies', 'public');

        $assembly = Assembly::create([
            ...$createAssemblyRequest->validated(),
            'image' => $imagePath
            ]);

        return redirect()->route('assemblies.show', $assembly);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        return Inertia::render('Assembly/AssemblyShow', [
            'assembly' => AssemblyResource::make(Assembly::with(["manufacturer", "components"])->where("id", $id)->firstOrFail())
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        return Inertia::render('Assembly/AssemblyEdit', [
            "assembly" => AssemblyResource::make(Assembly::with(["manufacturer", "components"])->where("id", $id)->firstOrFail()),
            "manufacturers" => Manufacturer::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateComponentRequest $updateAssemblyRequest
     * @param Assembly $assembly
     * @return RedirectResponse
     */
    public function update(UpdateComponentRequest $updateAssemblyRequest, Assembly $assembly)
    {
        $validatedInputs = $updateAssemblyRequest->validated();

        if($validatedInputs["new_image"])
            $validatedInputs["image"] = $updateAssemblyRequest->file('new_image')->store('images/assemblies', 'public');

        $assembly->update($validatedInputs);

        return redirect()->route('assemblies.show', $assembly);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Assembly $assembly
     * @return RedirectResponse
     */
    public function destroy(Assembly $assembly)
    {
        $assembly->delete();

        return redirect()->route('assemblies.index')->with('message', 'Post Delete Successfully');
    }
}
