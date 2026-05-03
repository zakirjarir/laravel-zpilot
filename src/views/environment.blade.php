@extends('installer::layout')

@section('title', 'Environment Setup')

@section('content')
    <h2>Environment Configuration</h2>
    <p>We've detected the following variables from your <code>.env.example</code>. Please provide the values for your new environment.</p>

    <form action="{{ route('installer.saveEnvironment') }}" method="POST">
        @csrf
        
        <div style="max-height: 400px; overflow-y: auto; padding-right: 10px; margin-bottom: 30px; border-bottom: 1px solid var(--border);">
            @foreach($envValues as $key => $value)
                <div class="form-group">
                    <label>{{ str_replace('_', ' ', $key) }} <small style="opacity: 0.6;">({{ $key }})</small></label>
                    <input type="{{ str_contains(strtolower($key), 'password') ? 'password' : 'text' }}" 
                           name="{{ $key }}" 
                           value="{{ $value }}" 
                           placeholder="Enter {{ strtolower(str_replace('_', ' ', $key)) }}"
                           {{ in_array($key, ['APP_NAME', 'DB_DATABASE', 'DB_USERNAME']) ? 'required' : '' }}>
                </div>
            @endforeach
        </div>

        <div class="btn-group">
            <a href="{{ route('installer.requirements') }}" class="btn btn-back">Back</a>
            <button type="submit" class="btn">Save & Continue</button>
        </div>
    </form>
@endsection
