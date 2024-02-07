<!-- footer-->
<div class="footer">
    <div class="no-gutters">
        <div class="col-auto mx-auto">
            <div class="row no-gutters justify-content-center">
                <div class="col-auto">
                    @if(Cookie::has('guest_word'))
                        <a href="{{ route('get.started') }}" class="btn btn-link-default  @if(Route::is('get.started')) active @endif">
                            <i class="material-icons">home</i>
                        </a>
                    @else
                        <a class="btn btn-link-default  @if(Route::is('get.started')) active @endif" id="guestAreaChangeBtn2">
                            <i class="material-icons">home</i>
                        </a>
                    @endif

                </div>
                {{-- <div class="col-auto">
                    <a href="{{ route('language') }}" class="btn btn-link-default">
                        <i class="material-icons">language</i>
                    </a>
                </div> --}}
                <div class="col-auto">
                    <a href="" class="btn btn-link-default "  data-toggle="modal" data-target="#LoginModalWhenClickOrder">
                        <i class="material-icons">account_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer ends-->
