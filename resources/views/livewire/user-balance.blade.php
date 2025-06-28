
<div class="row">
    <div class="col-md-8 col-8">
       {{ __('general.headers.dinero.option1') }}
    </div>
    <div class="col-md-4 col-4" id="balance_efectivo">${{ number_format($efectivo, 2) }}</div>
</div>
<div class="row">
    <div class="col-md-8 col-8">
        {{ __('general.headers.dinero.option2') }}
    </div>
    <div class="col-md-4 col-4">${{ number_format($inversion, 2)  }}</div>
</div>
<div class="row">
    <div class="col-md-8 col-8">
        {{ __('general.headers.dinero.option3') }}
    </div>
    <div class="col-md-4 col-4">${{ number_format($referidos, 2) }}</div>
</div>
<div class="row">
    <div class="col-md-8 col-8">
        {{ __('general.headers.dinero.option4') }}
    </div>
    <div class="col-md-4 col-4"> ${{  number_format($bonos, 2) }} </div>
</div>
