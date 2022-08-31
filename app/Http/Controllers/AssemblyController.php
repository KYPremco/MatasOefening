<?php

namespace App\Http\Controllers;

use App\Http\Requests\Assembly\CreateAssemblyRequest;
use App\Http\Requests\Assembly\OrderAssemblyRequest;
use App\Http\Requests\Assembly\UpdateAssemblyRequest;
use App\Http\Requests\Component\CreateComponentRequest;
use App\Http\Requests\Component\UpdateComponentRequest;
use App\Http\Resources\AssemblyResource;
use App\Models\Assembly;
use App\Models\Component;
use App\Models\Manufacturer;
use App\Models\Order;
use App\Models\User;
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
            'components' => Component::all('id', 'name'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAssemblyRequest $createAssemblyRequest
     * @return RedirectResponse
     */
    public function store(CreateAssemblyRequest $createAssemblyRequest)
    {
        $imagePath = $createAssemblyRequest->file('image')->store('images/assemblies', 'public');

        $validatedInputs = $createAssemblyRequest->validated();

        $assembly = Assembly::create([
            ...$validatedInputs,
            'image' => $imagePath,
        ]);

        $attachComponents = $this->getAttachComponents($validatedInputs['components']);

        $assembly->components()->attach($attachComponents);

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
            'components' => Component::all()
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
        // TODO: unique error when updating
        $validatedInputs = $updateAssemblyRequest->validated();

        if ($validatedInputs["new_image"])
            $validatedInputs["image"] = $updateAssemblyRequest->file('new_image')->store('images/assemblies', 'public');

        $assembly->update($validatedInputs);

        $attachComponents = $this->getAttachComponents($validatedInputs['components']);

        $assembly->components()->sync($attachComponents, false);


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

    public function order(OrderAssemblyRequest $orderAssemblyRequest, Assembly $assembly)
    {
        $validatedInputs = $orderAssemblyRequest->validated();
        $newOrder = $orderAssemblyRequest->user()->orders()->create([ "type" => "assembly" ]);
        $newOrder->assemblies()->create([
            ...$validatedInputs,
            "assembly_id" => $assembly->id,
            "price" => $assembly->price
        ]);

        return redirect()->route('assemblies.index')->with('message', 'Order aangemaakt');
    }

    /**
     * @param $inputComponents
     * @return array
     */
    public function getAttachComponents($inputComponents): array
    {
        $components = Component::findMany(array_column($inputComponents, 'id'));

        $attachComponents = [];
        for ($i = 0; $i < count($components); $i++) {
            $attachComponents[$i] = ['component_id' => $components[$i]->id, 'location' => $inputComponents[$i]['location']];
        }

        return $attachComponents;
    }
}
