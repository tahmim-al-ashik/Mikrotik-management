@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <h2>OLT Devices</h2>
            <a href="{{ route('olts.create') }}" class="btn btn-primary">Add New OLT</a>
        </div>

        <div class="row">
            @foreach($olts as $oltData)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header {{ $oltData['status']['online'] ? 'bg-success' : 'bg-danger' }}">
                            {{ $oltData['olt']->name }}
                            <span class="float-end badge bg-light text-dark">
                        {{ $oltData['status']['online'] ? 'Online' : 'Offline' }}
                    </span>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>IP:</strong> {{ $oltData['olt']->ip_address }}</p>
                            <p class="mb-1"><strong>Type:</strong> {{ $oltData['olt']->type }}</p>

                            @if($oltData['status']['online'])
                                <div class="alert alert-success mt-3 mb-0">
                                    <p class="mb-0">Uptime: {{ $oltData['status']['uptime'] }}</p>
                                    <small>Checked via {{ $oltData['status']['method'] }}</small>
                                </div>
                            @else
                                <div class="alert alert-danger mt-3 mb-0">
                                    Error: {{ $oltData['status']['error'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
