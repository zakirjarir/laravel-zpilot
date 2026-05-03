@extends('installer::layout')

@section('title', 'Database Setup')

@section('content')
    <div style="text-align: center;">
        <h2>Database Setup</h2>
        <p>Your environment variables have been saved. Now we need to set up your database tables.</p>
        
        <div style="margin: 30px 0; background: rgba(0,0,0,0.2); padding: 20px; border-radius: 12px; font-family: monospace; font-size: 0.9rem; text-align: left; color: #10b981;">
            > php artisan migrate --force
        </div>

        <form action="{{ route('installer.runMigrations') }}" method="POST">
            @csrf
            <button type="submit" class="btn">Run Migrations</button>
        </form>
    </div>
@endsection
