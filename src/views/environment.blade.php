@extends('zpilot::layout')

@section('title', 'Environment Setup')

<style>
    .zpilot-container { max-width: 850px !important; }
    .env-list {
        max-height: 450px;
        overflow-y: auto;
        padding-right: 15px;
        margin: 20px 0 30px 0;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 20px;
        border: 1px solid var(--border);
    }
    .env-row {
        display: flex;
        align-items: center;
        padding: 18px 20px;
        border-bottom: 1px solid var(--border);
        transition: background 0.3s ease;
    }
    .env-row:last-child { border-bottom: none; }
    .env-row:hover { background: rgba(255, 255, 255, 0.02); }
    
    .env-key {
        flex: 0 0 280px;
    }
    .env-label {
        color: #fff;
        font-size: 0.9rem;
        font-weight: 600;
        display: block;
    }
    .env-sub {
        color: var(--text-muted);
        font-size: 0.7rem;
        opacity: 0.6;
        margin-top: 3px;
        font-family: monospace;
    }
    .env-value {
        flex: 1;
    }
    .env-value input {
        margin-bottom: 0 !important;
        background: rgba(255, 255, 255, 0.05);
        padding: 12px 16px;
    }
    
    /* Custom Scrollbar */
    .env-list::-webkit-scrollbar { width: 6px; }
    .env-list::-webkit-scrollbar-track { background: transparent; }
    .env-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }
    .env-list::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }
</style>

@section('content')
    <h2>Environment Configuration</h2>
    <p>Please provide the values for your application environment. These were detected from your <code>.env.example</code>.</p>

    <form action="{{ route('zpilot.saveEnvironment') }}" method="POST">
        @csrf
        
        <div class="env-list">
            @foreach($envValues as $key => $value)
                <div class="env-row">
                    <div class="env-key">
                        <span class="env-label">{{ str_replace('_', ' ', $key) }}</span>
                        <span class="env-sub">{{ $key }}</span>
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
            <a href="{{ route('zpilot.requirements') }}" class="btn btn-back">Back</a>
            <button type="submit" class="btn">Save & Continue</button>
        </div>
    </form>
@endsection
