@if(session('success'))
    <div class="alert alert-success">
        <p style="margin-left:45%;">{{session('success')}}</p>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" style="margin-left: 35%;">
        <p style="margin-left:45%;">{{session('error')}}</p>
    </div>
@endif