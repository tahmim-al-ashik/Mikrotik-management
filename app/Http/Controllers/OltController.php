<?php

namespace App\Http\Controllers;
use App\Models\Olt;
use App\Services\OltManager;
use Illuminate\Http\Request;


class OltController extends Controller
{
    protected $oltManager;
    public function __construct()
    {
        $this->oltManager = new OltManager();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $olts = Olt::all()->map(function ($olt) {
            return [
                'olt' => $olt,
                'status' => $this->oltManager->getStatus($olt)
            ];
        });

        return view('olts.index', compact('olts'));
    }


    private function getOltStatus($olt) {
        $oltManager = new OltManager();
        return [
            'olt' => $olt,
            'status' => $oltManager->getStatus($olt)
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return view('olts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'type' => 'required|in:ZTE,HUAWEI,ALCATEL,OTHER',
            'snmp_community' => 'required|string',
            'snmp_port' => 'required|integer|between:1,65535',
            'ssh_username' => 'nullable|string',
            'ssh_password' => 'nullable|string',
            'ssh_port' => 'nullable|integer|between:1,65535',
            'active' => 'boolean'
        ]);

        Olt::create($validated);

        return redirect()->route('olts.index')->with('success', 'OLT added successfully!');
    }
}
