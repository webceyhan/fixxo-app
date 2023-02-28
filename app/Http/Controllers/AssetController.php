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
        return $this->edit(new Asset());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveAssetRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        return inertia('Assets/Show', [
            'asset' => $asset,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
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
        //
    }
}
