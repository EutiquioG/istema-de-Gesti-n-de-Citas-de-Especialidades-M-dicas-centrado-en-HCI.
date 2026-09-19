@if (session('success'))
    <div class="alert alert-success" role="status">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-error" role="alert">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error" role="alert">
        <strong>Revisa lo siguiente:</strong>
        <ul style="margin: 0.4rem 0 0 1.1rem; padding: 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif