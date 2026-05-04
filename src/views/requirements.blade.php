@extends('zpilot::layout')

@section('title', 'Server Requirements')

@section('content')
    <h2>Server Requirements</h2>
    <p>Please make sure your server meets the following requirements.</p>

    <style>
        .requirement-list {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 15px;
            margin: 20px 0 30px 0;
        }
        .requirement-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255,255,255,0.05);
            padding: 12px 18px;
            border-radius: 14px;
            margin-bottom: 8px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }
        .requirement-item:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.15);
        }
        .requirement-list::-webkit-scrollbar { width: 6px; }
        .requirement-list::-webkit-scrollbar-track { background: transparent; }
        .requirement-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }
        
        .req-section-title {
            font-size: 0.95rem;
            font-weight: 700;
            margin: 25px 0 12px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .req-section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
    </style>

    <div class="requirement-list">
        <h3 class="req-section-title">PHP Version</h3>
        <div class="requirement-item">
            <span>Required: {{ $requirements['php']['minimum'] }}+</span>
            <span style="font-weight: 700; color: {{ $requirements['php']['supported'] ? 'var(--success)' : 'var(--error)' }}">
                {{ $requirements['php']['current'] }}
                {!! $requirements['php']['supported'] ? '✓' : '✗' !!}
            </span>
        </div>

        <h3 class="req-section-title">Extensions</h3>
        @foreach($requirements['extensions'] as $ext => $enabled)
            <div class="requirement-item">
                <span style="font-weight: 500;">{{ ucfirst($ext) }}</span>
                <span style="font-weight: 700; color: {{ $enabled ? 'var(--success)' : 'var(--error)' }}">
                    {!! $enabled ? '✓' : '✗' !!}
                </span>
            </div>
        @endforeach

        <h3 class="req-section-title">Permissions</h3>
        @foreach($permissions['permissions'] as $path => $perm)
            <div class="requirement-item">
                <span style="font-size: 0.9rem; font-family: monospace; opacity: 0.8;">{{ $path }}</span>
                <span style="font-weight: 700; color: {{ $perm['isSet'] ? 'var(--success)' : 'var(--error)' }}">
                    {{ $perm['permission'] }}
                    {!! $perm['isSet'] ? '✓' : '✗' !!}
                </span>
            </div>
        @endforeach
    </div>

    @php
        $allRequirementsMet = $requirements['php']['supported'];
        foreach($requirements['extensions'] as $enabled) if(!$enabled) $allRequirementsMet = false;
        foreach($permissions['permissions'] as $perm) if(!$perm['isSet']) $allRequirementsMet = false;
    @endphp

    @if($allRequirementsMet)
        <div class="btn-group">
            <a href="{{ route('zpilot.welcome') }}" class="btn btn-back">Back</a>
            <a href="{{ route('zpilot.environment') }}" class="btn">Continue</a>
        </div>
    @else
        <div class="alert alert-error">
            Please fix the requirements/permissions issues above to continue.
        </div>
        <div class="btn-group">
            <a href="{{ route('zpilot.welcome') }}" class="btn btn-back">Back</a>
            <a href="{{ route('zpilot.requirements') }}" class="btn">Check Again</a>
        </div>
    @endif
@endsection
