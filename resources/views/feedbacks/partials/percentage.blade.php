@if($var == 0)
    <div class="alert alert-danger" role="alert">
        <strong>Terrible!</strong>
    </div>
@elseif($var == 1)
    <div class="alert alert-warning" role="alert">
        <strong>Bad!</strong>
    </div>
@elseif($var == 2)
    <div class="alert alert-default" role="alert">
        <strong>Okay!</strong>
    </div>
@elseif($var == 1)
    <div class="alert alert-primary" role="alert">
        <strong>Good!</strong>
    </div>
@else
    <div class="alert alert-success" role="alert">
        <strong>Great!</strong>
    </div>
@endif

