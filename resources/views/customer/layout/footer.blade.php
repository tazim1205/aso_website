<!-- footer-->
<div class="footer">
    <div class="no-gutters">
        <div class="col-auto mx-auto">
            <div class="row no-gutters justify-content-center">
                <div class="col-auto">
                    <a href="{{ route('customer.home.index') }}" class="btn btn-link-default  @if(Route::is('customer.home.index')) active @endif">
                        <i class="material-icons">home</i>
                    </a>
                </div>
                <div class="col-auto">
                    <a href="{{ route('customer.myJob') }}" class="btn btn-link-default  @if(Route::is('customer.myJob')) active @endif">
                        <i class="material-icons">gavel</i>
                    </a>
                </div>
                {{-- <div class="col-auto">
                    <a href="{{ route('customer.showGeneralServiceCategory') }}" class="btn btn-link-default @if(Route::is('customer.showGeneralServiceCategory')) active @endif">
                        <i class="material-icons">blur_linear</i>
                    </a>
                </div> --}}
                {{-- <div class="col-auto">
                    <a href="{{ route('language') }}" class="btn btn-link-default">
                        <i class="material-icons">language</i>
                    </a>
                </div> --}}
                <div class="col-auto">
                    <a href="{{ route('customer.profile.index') }}" class="btn btn-link-default @if(Route::is('customer.profile.index')) active @endif">
                        <i class="material-icons">account_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer ends-->
