@extends('zpilot::layout')

@section('title', 'Installation Finished')

@section('content')
    <div style="text-align: center;">
        <div style="margin-bottom: 25px;">
            <svg style="width: 80px; height: 80px; color: var(--success);" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h2>Installation Complete!</h2>
        <p>Your application is now configured and ready to use. You can now access your application.</p>
        
        <div class="alert alert-success">
            The .env file has been updated and migrations have been executed.
        </div>

        <a href="/" class="btn">Go to Application</a>
    </div>
@endsection
