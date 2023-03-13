<?php

namespace App\Http\Controllers;

use App\Enums\AssetStatus;
use App\Enums\AssetType;
use App\Http\Requests\SaveAssetRequest;
use App\Models\Asset;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowedParams = request()->only('search', 'type', 'status', 'brand');

        $assets = Asset::query()
            ->filterByParams($allowedParams)
            ->withCount(['tasks'])
            ->withSum('tasks as total_cost', 'price')
            ->with('customer:id,name')
            ->latest('id')
            ->paginate()
            ->withQueryString();

        // Get all distinct brands to use as filter options
        $brands = Asset::query()
            ->select('brand')
            ->distinct()
            ->whereNotNull('brand')
            ->get();


        return inertia('Assets/Index', [
            'assets' => $assets,
            'filters' => [
                'type' => AssetType::values(),
                'status' => AssetStatus::values(),
                'brand' => $brands->pluck('brand'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->edit(new Asset(
            request()->only('customer_id')
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveAssetRequest $request)
    {
        return $this->update($request, new Asset());
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        // TODO: improve this! only needed for aside card representation
        $asset->load('customer:id,name');

        return inertia('Assets/Show', [
            'asset' => $asset,
            'tasks' => $asset->tasks()->with('user:id,name')->get(),
            'payments' => $asset->payments()->with('user:id,name')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        // TODO: improve this! only needed for aside card representation
        $asset->load('customer');

        return inertia('Assets/Edit', [
            'asset' => $asset,

            'typeOptions' => AssetType::values(),
            'statusOptions' => AssetStatus::values(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveAssetRequest $request, Asset $asset)
    {
        $params = $request->validated();

        // TODO: improve this by using a custom request
        $params['user_id'] = auth()->id();

        $asset->fill($params)->save();

        return redirect()
            ->route('assets.show', $asset->id)
            ->with('status', __('record saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()
            ->route('assets.index')
            ->with('status', __('record deleted'));
    }
}
