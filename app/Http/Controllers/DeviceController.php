<?php

namespace App\Http\Controllers;

use App\Enums\DeviceStatus;
use App\Enums\DeviceType;
use App\Http\Requests\SaveDeviceRequest;
use App\Models\Device;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowedParams = request()->only('search', 'type', 'status', 'brand');

        $devices = Device::query()
            ->filterByParams($allowedParams)
            // ->withCount(['tasks'])
            // ->withSum('tasks as total_cost', 'cost')
            ->with('customer:id,name')
            ->latest('id')
            ->paginate()
            ->withQueryString();

        // Get all distinct brands to use as filter options
        $brands = Device::brands()->get();

        return inertia('Devices/Index', [
            'devices' => $devices,
            'filters' => [
                'type' => DeviceType::values(),
                'status' => DeviceStatus::values(),
                'brand' => $brands->pluck('brand'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->edit(new Device(
            request()->only('customer_id')
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveDeviceRequest $request)
    {
        return $this->update($request, new Device());
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        // TODO: improve this! only needed for aside card representation
        $device->load([
            'tickets',
            'user:id,name',
            'customer:id,name',
            'logs.user:id,name'
        ]);

        // append custom attributes
        $device->append([]);

        return inertia('Devices/Show', [
            'device' => $device,
            'canDelete' => auth()->user()->can('delete', $device),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        // TODO: improve this! only needed for aside card representation
        $device->load('customer');

        return inertia('Devices/Edit', [
            'device' => $device,
            'typeOptions' => DeviceType::values(),
            'statusOptions' => DeviceStatus::values(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveDeviceRequest $request, Device $device)
    {
        $params = $request->validated();

        // TODO: improve this by using a custom request
        $params['user_id'] = auth()->id();

        $device->fill($params)->save();

        return redirect()
            ->route('devices.show', $device->id)
            ->with('status', __('record saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        // TODO: use athorizeResource() here, see UserController::__construct()
        $this->authorize('delete', $device);

        $device->delete();

        return redirect()
            ->route('devices.index')
            ->with('status', __('record deleted'));
    }
}
