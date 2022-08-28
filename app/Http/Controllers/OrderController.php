<?php

namespace App\Http\Controllers;

use App\Http\Requests\Component\CreateComponentRequest;
use App\Http\Resources\ComponentResource;
use App\Http\Resources\OrderResource;
use App\Models\Component;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // AssemblyResource::collection(Assembly::with('manufacturer')
        return Inertia::render('Order/OrderIndex', [
            "orders" => OrderResource::collection(Order::with("assemblies", "assemblies.assembly:id,name")->where("user_id", $request->user()->id)->get()),
        ]);
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
}
