<?php

namespace App\Http\Controllers;

use App\Enums\AssetStatus;
use App\Enums\AssetType;
use App\Http\Requests\SaveAssetRequest;
use App\Models\Asset;
use App\Services\NotificationService;
use App\Services\SignatureService;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // redirect with the default status if no status is provided
        if (request()->input('status') === null) {
            return redirect()->route('assets.index', [
                'status' => AssetStatus::IN_PROGRESS
            ]);
        }

        $allowedParams = request()->only('search', 'type', 'status', 'brand');

        $query = Asset::query();

        if (isset($allowedParams['status']) && $allowedParams['status'] === AssetStatus::UNPAID) {
            unset($allowedParams['status']);
            $query->unpaid();
        }

        $assets = $query
            ->filterByParams($allowedParams)
            ->withCount(['tasks'])
            ->withSum('tasks as total_cost', 'price')
            ->with('customer:id,name')
            ->latest('id')
            ->paginate()
            ->withQueryString();

        // Get all distinct brands to use as filter options
        $brands = Asset::brands()->get();

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
        $asset->load(['user:id,name', 'customer:id,name']);

        // append custom attributes
        $asset->append([
            'cost',
            'balance',
            'balance_map',
            'qr_url',
            'intake_signature_url',
            'delivery_signature_url',
            'uploaded_urls'
        ]);

        return inertia('Assets/Show', [
            'asset' => $asset->append('cost'),
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


        // check if status is ready for pickup
        if ($asset->status == 'ready') {

            // send SMS to customer if phone number is provided
            if ($asset->customer->phone !== null) {
                $phone = $asset->customer->phone;
                $message = __('Your asset is ready for pickup.');

                try { // try to send SMS or skip
                    NotificationService::sendSMS($phone, $message);
                } catch (\Throwable $e) {
                    // TODO: log error
                }
            }
        }

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

    /**
     * Add signature to the specified asset.
     */
    public function sign(Asset $asset)
    {
        $type = request()->input('type');
        $blob = request()->input('blob');

        // TODO: see related Asset model attribute
        SignatureService::put("{$asset->id}-{$type}", $blob);

        return redirect()->back();
    }
}
