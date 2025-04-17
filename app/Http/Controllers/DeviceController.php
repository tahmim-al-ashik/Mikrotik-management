<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;
use RouterOS\Exceptions\ConnectException;

class DeviceController extends Controller
{
    // Show create form
    public function create()
    {
        return view('devices.create');
    }

    // Store new device
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'username' => 'required|string',
            'password' => 'required|string',
            'port' => 'required|integer|between:1,65535',
            'ssl' => 'boolean',
            'legacy_login' => 'boolean'
        ]);

        Device::create($validated);

        return redirect()->route('devices.index')->with('success', 'Device added successfully!');
    }

    // Show all devices with status
    public function index()
    {
        $devices = Device::all()->map(function ($device) {
            return $this->getDeviceStatus($device);
        });

        return view('devices.index', compact('devices'));
    }

    private function getDeviceStatus($device)
    {
        try {
            $config = (new Config())
                ->set('host', $device->ip_address)
                ->set('user', $device->username)
                ->set('pass', $device->password)
                ->set('port', $device->port)
                ->set('ssl', $device->ssl)
                ->set('legacy', $device->legacy_login);

            $client = new Client($config);

            // Get system identity
            $query = new Query('/system/identity/print');
            $identity = $client->query($query)->read()[0]['name'];

            // Get interfaces
            $query = new Query('/interface/print');
            $interfaces = $client->query($query)->read();

            return [
                'device' => $device,
                'status' => 'active',
                'identity' => $identity,
                'interfaces' => $interfaces
            ];

        } catch (ConnectException $e) {
            return [
                'device' => $device,
                'status' => 'inactive',
                'error' => $e->getMessage()
            ];
        }
    }
}
