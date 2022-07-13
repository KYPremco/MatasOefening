<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assembly\CreateAssemblyRequest;
use App\Http\Requests\Assembly\UpdateAssemblyRequest;
use App\Http\Resources\AssemblyResource;
use App\Models\Assembly;
use App\Models\Manufacturer;
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
    public function index()
    {
        return Inertia::render('Assembly/AssemblyIndex', [
            "assemblies" => AssemblyResource::collection(Assembly::with('manufacturer')->get())
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
     * @param  CreateAssemblyRequest  $createAssemblyRequest
     * @return RedirectResponse
     */
    public function store(CreateAssemblyRequest $createAssemblyRequest)
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
     * @param UpdateAssemblyRequest $updateAssemblyRequest
     * @param Assembly $assembly
     * @return RedirectResponse
     */
    public function update(UpdateAssemblyRequest $updateAssemblyRequest, Assembly $assembly)
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
