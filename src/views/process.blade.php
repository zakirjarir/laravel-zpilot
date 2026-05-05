@extends('zpilot::layout')

@section('title', 'Database Installation')

@section('content')
    <div style="text-align: center;">
        <h2>Finalizing Installation</h2>
        <p>Your environment and database connection are configured. Now we will set up the tables and initial data.</p>
        
        <form action="{{ route('zpilot.runInstallation') }}" method="POST">
            @csrf
            <div style="background: rgba(0, 0, 0, 0.2); padding: 30px; border-radius: 24px; margin: 30px 0; text-align: left; border: 1px solid var(--border);">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="width: 24px; height: 24px; background: var(--success); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <svg style="width: 14px; height: 14px; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span style="color: #fff; font-weight: 600;">Run Migrations</span>
                </div>
                
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="width: 24px; height: 24px; background: var(--success); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <svg style="width: 14px; height: 14px; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span style="color: #fff; font-weight: 600;">Generate Application Key</span>
                </div>
                
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="width: 24px; height: 24px; background: var(--success); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <svg style="width: 14px; height: 14px; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span style="color: #fff; font-weight: 600;">Create Storage Link</span>
                </div>

                @if(count($detectedPackages) > 0)
                    <div style="margin: 25px 0 15px; color: var(--text-muted); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; opacity: 0.8;">Detected Packages</div>
                    @foreach($detectedPackages as $package)
                        <div style="display: flex; align-items: center; margin-bottom: 15px; padding: 12px 15px; background: rgba(255,255,255,0.03); border-radius: 12px; border: 1px solid var(--border);">
                            <input type="checkbox" name="setup_packages[]" value="{{ $package['command'] }}" id="pkg_{{ $loop->index }}" checked style="width: 18px; height: 18px; margin-right: 15px; accent-color: var(--primary); cursor: pointer;">
                            <label for="pkg_{{ $loop->index }}" style="color: #fff; font-weight: 500; cursor: pointer; margin-bottom: 0; text-transform: none; letter-spacing: 0;">Setup {{ $package['name'] }}</label>
                        </div>
                    @endforeach
                @endif
                
                <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid var(--border);">
                    <div style="display: flex; align-items: flex-start; cursor: pointer; padding: 12px; border-radius: 14px; transition: background 0.3s ease;">
                        <input type="checkbox" name="fresh_install" id="fresh_install" style="width: 20px; height: 20px; margin-right: 15px; accent-color: var(--primary); margin-top: 3px; cursor: pointer;">
                        <div>
                            <label for="fresh_install" style="color: #fff; font-weight: 700; cursor: pointer; margin-bottom: 2px; display: block;">Fresh Installation</label>
                            <span style="color: var(--text-muted); font-size: 0.75rem; display: block; opacity: 0.7;">Wipe all existing tables and data before installing. <span style="color: #ff4d4d;">Warning: This cannot be undone.</span></span>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; align-items: center; cursor: pointer; padding: 12px;">
                    <input type="checkbox" name="run_seed" id="seed" checked style="width: 20px; height: 20px; margin-right: 15px; accent-color: var(--primary); cursor: pointer;">
                    <label for="seed" style="color: #fff; font-weight: 600; cursor: pointer; margin-bottom: 0;">Run Database Seeders (Recommended)</label>
                </div>
            </div>

            <div class="btn-group">
                <a href="{{ route('zpilot.environment') }}" class="btn btn-back">Back</a>
                <button type="submit" class="btn">Start Installation</button>
            </div>
            <p style="margin-top: 15px; font-size: 0.85rem;">This may take a few seconds...</p>
        </form>
    </div>
@endsection
