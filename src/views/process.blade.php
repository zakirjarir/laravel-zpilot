@extends('installer::layout')

@section('title', 'Database Installation')

@section('content')
    <div style="text-align: center;">
        <h2>Finalizing Installation</h2>
        <p>Your environment and database connection are configured. Now we will set up the tables and initial data.</p>
        
        <form action="{{ route('installer.runInstallation') }}" method="POST">
            @csrf
            <div style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: 20px; margin: 30px 0; text-align: left; border: 1px solid var(--border);">
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="width: 24px; height: 24px; background: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <svg style="width: 14px; height: 14px; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span style="color: #fff; font-weight: 500;">Run Migrations (Automatic)</span>
                </div>
                
                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="width: 24px; height: 24px; background: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <svg style="width: 14px; height: 14px; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span style="color: #fff; font-weight: 500;">Generate Application Key (Automatic)</span>
                </div>

                <div style="display: flex; align-items: center; margin-bottom: 20px;">
                    <div style="width: 24px; height: 24px; background: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <svg style="width: 14px; height: 14px; color: #fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span style="color: #fff; font-weight: 500;">Generate Application Key (Automatic)</span>
                </div>

                @if(count($detectedPackages) > 0)
                    <div style="margin-bottom: 10px; color: var(--text-muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Detected Packages</div>
                    @foreach($detectedPackages as $package)
                        <div style="display: flex; align-items: center; margin-bottom: 15px; padding-left: 10px;">
                            <input type="checkbox" name="setup_packages[]" value="{{ $package['command'] }}" id="pkg_{{ $loop->index }}" checked style="width: 18px; height: 18px; margin-right: 15px; accent-color: var(--primary);">
                            <label for="pkg_{{ $loop->index }}" style="color: #fff; font-weight: 500; cursor: pointer; margin-bottom: 0; text-transform: none; letter-spacing: 0;">Setup {{ $package['name'] }}</label>
                        </div>
                    @endforeach
                @endif
                
                <div style="margin-top: 10px; display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="run_seed" id="seed" checked style="width: 20px; height: 20px; margin-right: 15px; accent-color: var(--primary);">
                    <label for="seed" style="color: #fff; font-weight: 500; cursor: pointer;">Run Database Seeders (Recommended)</label>
                </div>
            </div>

            <div class="btn-group">
                <a href="{{ route('installer.environment') }}" class="btn btn-back">Back</a>
                <button type="submit" class="btn">Start Installation</button>
            </div>
            <p style="margin-top: 15px; font-size: 0.85rem;">This may take a few seconds...</p>
        </form>
    </div>
@endsection
