@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add New MikroTik Device</h2>
        <form method="POST" action="{{ route('devices.store') }}">
            @csrf
            <div class="mb-3">
                <label>Device Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>IP Address</label>
                        <input type="text" name="ip_address" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Port</label>
                        <input type="number" name="port" class="form-control" value="8728" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ssl" id="ssl">
                    <label class="form-check-label" for="ssl">Use SSL</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="legacy_login" id="legacy_login">
                    <label class="form-check-label" for="legacy_login">Legacy Login (RouterOS < 6.43)</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Add Device</button>
        </form>
    </div>
@endsection
