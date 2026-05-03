@extends('installer::layout')

@section('title', 'Environment Setup')

@section('content')
    <h2>Environment Configuration</h2>
    <p>Please provide your basic application and database settings.</p>

    <form action="{{ route('installer.saveEnvironment') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>App Name</label>
            <input type="text" name="app_name" value="Laravel" required>
        </div>

        <div class="form-group">
            <label>App URL</label>
            <input type="text" name="app_url" value="http://localhost" required>
        </div>

        <div style="margin: 25px 0; border-top: 1px solid var(--border); padding-top: 25px;">
            <h3 style="font-size: 1.1rem; margin-bottom: 15px;">Database Settings</h3>
            
            <div class="form-group">
                <label>Connection</label>
                <select name="database_connection">
                    <option value="mysql" selected>MySQL</option>
                    <option value="sqlite">SQLite</option>
                    <option value="pgsql">PostgreSQL</option>
                </select>
            </div>

            <div class="form-group">
                <label>Host</label>
                <input type="text" name="database_host" value="127.0.0.1" required>
            </div>

            <div class="form-group">
                <label>Port</label>
                <input type="text" name="database_port" value="3306" required>
            </div>

            <div class="form-group">
                <label>Database Name</label>
                <input type="text" name="database_name" value="laravel" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="database_username" value="root" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="database_password" value="">
            </div>
        </div>

        <button type="submit" class="btn">Save & Continue</button>
    </form>
@endsection
