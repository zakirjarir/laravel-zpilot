@extends('installer::layout')

@section('title', 'Server Requirements')

@section('content')
    <h2>Server Requirements</h2>
    <p>Please make sure your server meets the following requirements.</p>

    <div style="margin-bottom: 30px;">
        <h3 style="font-size: 1.1rem; margin-bottom: 10px; color: #fff;">PHP Version</h3>
        <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.05); padding: 12px; border-radius: 12px; margin-bottom: 20px;">
            <span>Required: {{ $requirements['php']['minimum'] }}+</span>
            <span style="font-weight: 600; color: {{ $requirements['php']['supported'] ? 'var(--success)' : 'var(--error)' }}">
                {{ $requirements['php']['current'] }}
                {!! $requirements['php']['supported'] ? '✓' : '✗' !!}
            </span>
        </div>

        <h3 style="font-size: 1.1rem; margin-bottom: 10px; color: #fff;">Extensions</h3>
        @foreach($requirements['extensions'] as $ext => $enabled)
            <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.05); padding: 10px 12px; border-radius: 8px; margin-bottom: 8px;">
                <span>{{ ucfirst($ext) }}</span>
                <span style="color: {{ $enabled ? 'var(--success)' : 'var(--error)' }}">
                    {!! $enabled ? '✓' : '✗' !!}
                </span>
            </div>
        @endforeach

        <h3 style="font-size: 1.1rem; margin: 25px 0 10px; color: #fff;">Permissions</h3>
        @foreach($permissions['permissions'] as $path => $perm)
            <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.05); padding: 10px 12px; border-radius: 8px; margin-bottom: 8px;">
                <span style="font-size: 0.9rem;">{{ $path }}</span>
                <span style="color: {{ $perm['isSet'] ? 'var(--success)' : 'var(--error)' }}">
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
        <a href="{{ route('installer.environment') }}" class="btn">Continue</a>
    @else
        <div class="alert alert-error">
            Please fix the requirements/permissions issues above to continue.
        </div>
        <a href="{{ route('installer.requirements') }}" class="btn btn-outline">Check Again</a>
    @endif
@endsection
