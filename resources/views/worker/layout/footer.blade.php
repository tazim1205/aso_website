<!-- footer-->
<div class="footer">
    <div class="no-gutters">
        <div class="col-auto mx-auto">
            <div class="row no-gutters justify-content-center">
                <div class="col-auto">
                    <a href="{{ route('worker.home.index') }}" class="btn btn-link-default  @if(Route::is('worker.home.index')) active @endif">
                        <i class="material-icons">home</i>
                    </a>
                </div>
                <div class="col-auto">
                    <a href="{{ route('worker.job.index') }}" class="btn btn-link-default  @if(Route::is('worker.job.index')) active @endif">
                        <i class="material-icons">insert_chart_outline</i>
                    </a>
                </div>
                <div class="col-auto">
                    <a href="{{ route('worker.gig.index') }}" class="btn btn-link-default @if(Route::is('worker.gig.index')) active @endif">
                        <i class="material-icons">add_to_queue</i>
                    </a>
                </div>
                {{-- <div class="col-auto">
                    <a href="{{ route('language') }}" class="btn btn-link-default">
                        <i class="material-icons">language</i>
                    </a>
                </div> --}}

            {{-- @if(auth()->user()->membership)
                @if(auth()->user()->membershipPages->count() > 0)
                <div class="col-auto">
                    <a href="{{ route('worker.membership.page.index') }}" class="btn btn-link-default @if(Route::is('membership.page.index')) active @endif">
                        <i class="material-icons">widgets</i>
                    </a>
                </div>
                @else
                <div class="col-auto">
                    <a href="{{ route('worker.membership.page.create') }}" class="btn btn-link-default @if(Route::is('membership.page.create')) active @endif">
                        <i class="material-icons">widgets</i>
                    </a>
                </div>
                @endif
            @else
            <div class="col-auto">
                <a href="{{ route('worker.member_home.index') }}" class="btn btn-link-default @if(Route::is('membership.home.index')) active @endif">
                    <i class="material-icons">widgets</i>
                </a>
            </div>
            @endif --}}
                <div class="col-auto">
                    <a href="{{ route('worker.profile.index') }}" class="btn btn-link-default @if(Route::is('worker.profile.index')) active @endif">
                        <i class="material-icons">account_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer ends-->
