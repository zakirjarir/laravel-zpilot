@extends('zpilot::layout')

@section('title', 'Welcome')

@section('content')
    <div style="text-align: center;">
        <h2>Welcome to the Setup Wizard</h2>
        <p>This wizard will help you configure your Laravel application easily. We'll set up your environment variables, database, and seeders.</p>
        
        <div style="margin: 30px 0;">
            <svg style="width: 80px; height: 80px; color: var(--primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>

        <a href="{{ route('zpilot.requirements') }}" class="btn">Get Started</a>
    </div>
@endsection
