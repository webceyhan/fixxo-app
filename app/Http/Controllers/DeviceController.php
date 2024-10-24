<?php

namespace App\Http\Controllers;

use App\Enums\DeviceStatus;
use App\Enums\DeviceType;
use App\Http\Requests\SaveDeviceRequest;
use App\Models\Device;
use App\Queries\DeviceQuery;
use Illuminate\Support\Facades\Gate;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Devices/Index', [
            'devices' => (new DeviceQuery)->paginate(),
            'filters' => DeviceQuery::filters(),
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
            'customer:id,name',
            'logs.user:id,name'
        ]);

        // append custom attributes
        $device->append([]);

        return inertia('Devices/Show', [
            'device' => $device,
            'canDelete' => Gate::allows('delete', $device),
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
        Gate::authorize('delete', $device);

        $device->delete();

        return redirect()
            ->route('devices.index')
            ->with('status', __('record deleted'));
    }
}
