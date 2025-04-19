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
                            <p class="mb-1"><strong>IP:</strong> {{ $device['device']->ip_address }} :{{ $device['device']->port }}</p>

                            @if($device['status'] === 'active')
                                <h5 class="mt-3">Network Interfaces</h5>
                                <div class="list-group mb-4">
                                    @foreach($device['interfaces'] as $interface)
                                        <div class="list-group-item">
                                            <div class="d-flex justify-content-between">
                                                <strong>{{ $interface['name'] }}</strong>
                                                <span class="badge {{ $interface['running'] ? 'bg-success' : 'bg-secondary' }}">
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

                                <!-- Live Traffic Chart -->
                                <h5 class="mt-3">Live Traffic</h5>
                                <canvas id="trafficChart-{{ $device['device']->id }}" height="100"></canvas>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const chartId = "{{ $device['device']->id }}";
                                        const ctx = document.getElementById(`trafficChart-${chartId}`).getContext('2d');

                                        const chart = new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: [],
                                                datasets: [
                                                    {
                                                        label: 'RX (KBps)',
                                                        data: [],
                                                        borderColor: 'green',
                                                        backgroundColor: 'rgba(0,255,0,0.1)',
                                                        fill: true,
                                                        tension: 0.4
                                                    },
                                                    {
                                                        label: 'TX (KBps)',
                                                        data: [],
                                                        borderColor: 'blue',
                                                        backgroundColor: 'rgba(0,0,255,0.1)',
                                                        fill: true,
                                                        tension: 0.4
                                                    }
                                                ]
                                            },
                                            options: {
                                                animation: false,
                                                responsive: true,
                                                scales: {
                                                    y: {
                                                        beginAtZero: true,
                                                        title: {
                                                            display: true,
                                                            text: 'Kilobytes per second (KBps)'
                                                        }
                                                    },
                                                    x: {
                                                        title: {
                                                            display: true,
                                                            text: 'Time'
                                                        }
                                                    }
                                                }
                                            }
                                        });

                                        let lastStats = {
                                            time: null,
                                            rx: 0,
                                            tx: 0
                                        };

                                        function fetchTraffic() {
                                            fetch("{{ route('devices.interfaces', ['device' => $device['device']->id]) }}")
                                                .then(res => res.json())
                                                .then(data => {
                                                    if (data.status === 'success') {
                                                        const now = Date.now();
                                                        const totalRx = data.interfaces.reduce((sum, intf) => sum + parseInt(intf['rx-byte'] ?? 0), 0);
                                                        const totalTx = data.interfaces.reduce((sum, intf) => sum + parseInt(intf['tx-byte'] ?? 0), 0);

                                                        if (lastStats.time !== null) {
                                                            const secondsPassed = (now - lastStats.time) / 1000;

                                                            const rxSpeed = (totalRx - lastStats.rx) / secondsPassed / 1024; // KBps
                                                            const txSpeed = (totalTx - lastStats.tx) / secondsPassed / 1024;

                                                            const timeLabel = new Date().toLocaleTimeString();

                                                            chart.data.labels.push(timeLabel);
                                                            chart.data.datasets[0].data.push(rxSpeed.toFixed(2));
                                                            chart.data.datasets[1].data.push(txSpeed.toFixed(2));

                                                            if (chart.data.labels.length > 10) {
                                                                chart.data.labels.shift();
                                                                chart.data.datasets[0].data.shift();
                                                                chart.data.datasets[1].data.shift();
                                                            }

                                                            chart.update();
                                                        }

                                                        lastStats = {
                                                            time: now,
                                                            rx: totalRx,
                                                            tx: totalTx
                                                        };
                                                    }
                                                })
                                                .catch(err => console.error('Traffic fetch error:', err));
                                        }

                                        setInterval(fetchTraffic, 3000);
                                    });
                                </script>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
