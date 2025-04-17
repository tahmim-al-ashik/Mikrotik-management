@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between mb-4">
            <h2>MikroTik Devices</h2>
            <a href="{{ route('devices.create') }}" class="btn btn-success">Add New Device</a>
        </div>

        <div class="row">
            @foreach($devices as $device)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center
                        {{ $device['status'] === 'active' ? 'bg-success' : 'bg-danger' }}">
                            <div>
                                {{ $device['device']->name }}
                                @if($device['status'] === 'active')
                                    <small class="text-muted">({{ $device['identity'] }})</small>
                                @endif
                            </div>
                            <span class="badge bg-light text-dark">
                            {{ $device['status'] === 'active' ? 'Online' : 'Offline' }}
                        </span>
                        </div>

                        <div class="card-body">
                            <p class="mb-1"><strong>IP:</strong> {{ $device['device']->ip_address }}
                                :{{ $device['device']->port }}</p>

                            @if($device['status'] === 'active')
                                <h5 class="mt-3">Network Interfaces</h5>
                                <div class="list-group">
                                    @foreach($device['interfaces'] as $interface)
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <strong>{{ $interface['name'] }}</strong>
                                                <span class="badge
                                                {{ $interface['running'] ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $interface['running'] ? 'Up' : 'Down' }}
                                            </span>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col">
                                                    <small>RX: {{ App\Helpers\FormatHelper::bytes($interface['rx-byte'] ?? 0) }}</small>
                                                </div>
                                                <div class="col">
                                                    <small>TX: {{ App\Helpers\FormatHelper::bytes($interface['tx-byte'] ?? 0) }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
{{--                                <div class="alert alert-danger mt-3">--}}
{{--                                    Connection Error: {{ $device['error'] }}--}}
{{--                                </div>--}}

                                <div class="alert alert-danger mt-3">
                                    Connection Error: Check your api port after on your mikrotik device
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{--    @php--}}
    {{--        function formatBytes($bytes) {--}}
    {{--            $units = ['B', 'KB', 'MB', 'GB', 'TB'];--}}
    {{--            $bytes = max($bytes, 0);--}}
    {{--            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));--}}
    {{--            $pow = min($pow, count($units) - 1);--}}
    {{--            return round($bytes / (1024 ** $pow), 2) . ' ' . $units[$pow];--}}
    {{--        }--}}
    {{--    @endphp--}}
@endsection
