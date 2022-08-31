<?php

namespace App\Http\Controllers;

use App\Http\Requests\Component\CreateComponentRequest;
use App\Http\Requests\Component\UpdateComponentRequest;
use App\Http\Resources\ComponentResource;
use App\Models\Component;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ComponentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $search = $request->get("search");

        return Inertia::render('Component/ComponentIndex', [
            "search" => $search,
            "components" => ComponentResource::collection(Component::filterName($search)->get())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Component/ComponentCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateComponentRequest  $createComponentRequest
     * @return RedirectResponse
     */
    public function store(CreateComponentRequest $createComponentRequest)
    {
        $imagePath = $createComponentRequest->file('image')->store('images/components', 'public');

        $component = Component::create([
            ...$createComponentRequest->validated(),
            'image' => $imagePath
        ]);

        return redirect()->route('components.show', ['component' => $component->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        return Inertia::render('Component/ComponentShow', [
            'component' => ComponentResource::make(Component::where("id", $id)->firstOrFail())
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
        return Inertia::render('Component/ComponentEdit', [
            "component" => ComponentResource::make(Component::with(["assemblies"])->where("id", $id)->firstOrFail())
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateComponentRequest $updateComponentRequest
     * @param Component $component
     * @return RedirectResponse
     */
    public function update(UpdateComponentRequest $updateComponentRequest, Component $component)
    {
        $validatedInputs = $updateComponentRequest->validated();

        if($validatedInputs["new_image"])
            $validatedInputs["image"] = $updateComponentRequest->file('new_image')->store('images/components', 'public');

        $component->update($validatedInputs);

        return redirect()->route('components.show', $component);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Component $component
     * @return RedirectResponse
     */
    public function destroy(Component $component)
    {
        $component->delete();

        return redirect()->route('components.index')->with('message', 'Post Delete Successfully');
    }
}
