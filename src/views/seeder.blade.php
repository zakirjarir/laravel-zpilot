@extends('installer::layout')

@section('title', 'Database Seeding')

@section('content')
    <div style="text-align: center;">
        <h2>Populate Database</h2>
        <p>Migrations were successful! Would you like to run the database seeders to populate initial data?</p>
        
        <div style="margin: 30px 0; background: rgba(0,0,0,0.2); padding: 20px; border-radius: 12px; font-family: monospace; font-size: 0.9rem; text-align: left; color: #10b981;">
            > php artisan db:seed --force
        </div>

        <form action="{{ route('installer.runSeeders') }}" method="POST">
            @csrf
            <button type="submit" class="btn">Run Seeders</button>
            <a href="{{ route('installer.finish') }}" class="btn btn-outline" style="margin-top: 15px;">Skip Seeding</a>
        </form>
    </div>
@endsection
