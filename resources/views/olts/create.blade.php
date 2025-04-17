@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add New OLT</h2>

        <form method="POST" action="{{ route('olts.store') }}">
            @csrf

            <div class="mb-3">
                <label>OLT Name</label>
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
                        <label>OLT Type</label>
                        <select name="type" class="form-select" required>
                            <option value="ZTE">ZTE</option>
                            <option value="HUAWEI">HUAWEI</option>
                            <option value="ALCATEL">ALCATEL</option>
                            <option value="OTHER">Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>SNMP Community</label>
                        <input type="text" name="snmp_community" class="form-control" value="public" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>SNMP Port</label>
                        <input type="number" name="snmp_port" class="form-control" value="161" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label>SSH Username</label>
                        <input type="text" name="ssh_username" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label>SSH Password</label>
                        <input type="password" name="ssh_password" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label>SSH Port</label>
                        <input type="number" name="ssh_port" class="form-control" value="22">
                    </div>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="active" class="form-check-input" checked>
                <label class="form-check-label">Active</label>
            </div>

            <button type="submit" class="btn btn-primary">Add OLT</button>
        </form>
    </div>
@endsection
