@extends('installer::layout')

@section('title', 'Environment Setup')

<style>
    .installer-container { max-width: 850px !important; } /* Increasing width for this page */
    .env-row {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
        gap: 20px;
    }
    .env-key {
        flex: 0 0 250px;
        color: var(--text-muted);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .env-value {
        flex: 1;
    }
    .env-value input {
        margin-bottom: 0 !important;
    }
    .env-list {
        max-height: 500px;
        overflow-y: auto;
        padding-right: 15px;
        margin-bottom: 30px;
    }
</style>

@section('content')
    <h2>Environment Configuration</h2>
    <p>Please provide the values for your application environment. These were detected from your <code>.env.example</code>.</p>

    <form action="{{ route('installer.saveEnvironment') }}" method="POST">
        @csrf
        
        <div class="env-list">
            @foreach($envValues as $key => $value)
                <div class="env-row">
                    <div class="env-key">
                        {{ str_replace('_', ' ', $key) }}
                        <div style="font-size: 0.7rem; opacity: 0.5; margin-top: 2px;">{{ $key }}</div>
                    </div>
                    <div class="env-value">
                        <input type="{{ str_contains(strtolower($key), 'password') ? 'password' : 'text' }}" 
                               name="{{ $key }}" 
                               value="{{ $value }}" 
                               placeholder="Enter {{ strtolower(str_replace('_', ' ', $key)) }}"
                               {{ in_array($key, ['APP_NAME', 'DB_DATABASE', 'DB_USERNAME']) ? 'required' : '' }}>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="btn-group">
            <a href="{{ route('installer.requirements') }}" class="btn btn-back">Back</a>
            <button type="submit" class="btn">Save & Continue</button>
        </div>
    </form>
@endsection
