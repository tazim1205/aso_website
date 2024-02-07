<!-- footer-->
<div class="footer">
    <div class="no-gutters">
        <div class="col-auto mx-auto">
            <div class="row no-gutters justify-content-center">
                <div class="col-auto">
                    <a href="{{ route('membership.home.index') }}" class="btn btn-link-default active">
                        <i class="material-icons">home</i>
                    </a>
                </div>
                {{-- <div class="col-auto">
                    <a href="javascript:0" class="btn btn-link-default">
                        <i class="material-icons">insert_chart_outline</i>
                    </a>
                </div> --}}
                <div class="col-auto">
                    <a href="{{ route('language') }}" class="btn btn-link-default">
                        <i class="material-icons">language</i>
                    </a>
                </div>

                    @if(auth()->user()->membership)
                        @if(auth()->user()->membershipPages->count() > 0)
                        <div class="col-auto">
                            <a href="{{ route('membership.page.index') }}" class="btn btn-link-default @if(Route::is('membership.page.index')) active @endif">
                                <i class="material-icons">widgets</i>
                            </a>
                        </div>
                        @else
                        <div class="col-auto">
                            <a href="{{ route('membership.page.create') }}" class="btn btn-link-default @if(Route::is('membership.page.create')) active @endif">
                                <i class="material-icons">widgets</i>
                            </a>
                        </div>
                        @endif
                    @else
                    <div class="col-auto">
                        <a href="{{ route('membership.home.index') }}" class="btn btn-link-default @if(Route::is('membership.home.index')) active @endif">
                            <i class="material-icons">widgets</i>
                        </a>
                    </div>
                    @endif
                <div class="col-auto">
                    <a href="{{ route('membership.profile.index') }}" class="btn btn-link-default @if(Route::is('membership.profile.index')) active @endif">
                        <i class="material-icons">account_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer ends-->
