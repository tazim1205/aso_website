<section class="three-dot">
    <div class="bar-area">
        <div class="bar-cont">
            <div class="bar-id">
                <div class="bar-id-img">
                    <div class="bar-img-cir">
                        <img src="{{ asset(auth()->user()->image ?? 'uploads/images/defaults/user.png') }}" alt="">
                    </div>
                </div>
                <div class="bar-id-name">
                    <h3>{{ auth()->user()->full_name }}
                        @if(auth()->user()->is_verified)
                            <i class="material-icons icons-raised bg-success">check_circle</i>
                        @endif</h3>
                    <p>{{ auth()->user()->phone }}</p>
                </div>
            </div>
            <div class="bar-menu-area">
                <a href="{{ route('worker.home.index') }}" class="@if(Route::is('customer.home.index')) active @endif">
                    <div class="bar-menu">
                        <div class="bar-menu-img">
                            <div class="bar-img-cir-1"><i class="fa-solid fa-house"></i>
                            </div>
                        </div>
                        <div class="bar-menu-name">
                            <p> {{ __('হোম') }} </p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('worker.job.index') }}" class="@if(Route::is('customer.myJob')) active @endif">
                    <div class="bar-menu">
                        <div class="bar-menu-img">
                            <div class="bar-img-cir-1"><i class="fa-solid fa-bag-shopping"></i>
                            </div>
                        </div>
                        <div class="bar-menu-name">
                            <p>{{ __('অর্ডার') }}</p>
                        </div>
                    </div>
                </a>

                <div class="bar-menu">
                    <div class="bar-menu-img">
                        <div class="bar-img-cir-1"><i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                    <div class="bar-menu-name location">
                        <p>{{ __('আমার এরিয়া') }}</p>
                    </div>
                </div>

                <a href="{{ route('worker.profile.index') }}" class="@if(Route::is('customer.profile.index')) active @endif">
                    <div class="bar-menu">
                        <div class="bar-menu-img">
                            <div class="bar-img-cir-1"><i class="fa-solid fa-user"></i>
                            </div>
                        </div>
                        <div class="bar-menu-name">
                            <p>{{ __('প্রোফাইল') }}</p>
                        </div>
                    </div>
                </a>

                <div class="bar-menu">
                    <div class="bar-menu-img">
                        <div class="bar-img-cir-1"><i class="fa-solid fa-palette"></i>
                        </div>
                    </div>
                    <div class="bar-menu-name colo">
                        <p>কালার</p>
                    </div>
                </div>

                <div class="bar-menu">
                    <div class="bar-menu-img">
                        <div class="bar-img-cir-1 sign-1"><i class="fa-solid fa-right-from-bracket"></i>
                        </div>
                    </div>
                    <div class="bar-menu-name signout sk  signout">
                        <p>সাইন আউট</p>
                    </div>
                </div>
            </div>
            <div class="bar-cross">
                <i class="fa-regular fa-circle-xmark"></i>
            </div>
        </div>
    </div>


    <div class="my-container color-pic">
        <div class="color-head">
            <h2>
                Color Picture
            </h2>
            <i class="fa-solid fa-xmark colo-1"></i>
        </div>
        <div class="color-area">
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
            <div class="color">
                <i class="fa-solid fa-palette"></i>
            </div>
        </div>
        <div class="night-mood">
            <i class="fas fa-sun"></i>
            <i class="fas fa-toggle-on"></i>
            <i class="fa-solid fa-moon"></i>

        </div>
    </div>
    <div class="write-pass-1 my-container">
        <div class="edit-image ">
            <i class="fas fa-exclamation"></i>
        </div>
        <h2>Are you sure?</h2>
        <h3>আপনি পুনরায় আসো তে সাইন ইন করতে পারবেন।
        </h3>
        <div class="login-form">
            <div class="pre-next">
                <input type="text" value="Cancel" class="btn-n-1 cn-2">
                <input type="submit" value="Submit" onclick="logout()">
            </div>

        </div>
    </div>

    <div class="my-location">
        <div class="login-area loc-area lc">
            <i class="fa-solid fa-xmark colo-2"></i>
            <div class="login-content">
                <div class="login-img">
                    <img src="../asset/image/3196533 1.png  " alt="Log in Image">
                </div>
                <div class="login-info loc-head">
                    <h2>আপনার লোকেশন নির্বাচন করুন</h2>
                </div>
                <div class="login-form loc-form">
                    <form>
                        <select name="District" placeholder="Feni | ফেনী">
                            <option value="Dhaka">Select জেলা</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                        </select>

                        <select name="Upzilla" placeholder="Feni Sadar | ফেনী সদর">
                            <option value="Dhaka">Select মেট্রোপলিটন থানা / উপজেলা</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                        </select>

                        <select name="Pouroshoba" placeholder="Feni Pouroshova">
                            <option value="Dhaka">Select এরিয়া /পৌরসভা /ইউনিয়ন</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                        </select>

                        <select name="Pouroshoba" placeholder="Select Word/Road">
                            <option value="Dhaka">Select রোড / ওয়ার্ড</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                            <option value="Dhaka">Dhaka</option>
                        </select>
                        <input type="text" placeholder="আপনার Google Map লিংক">
                        <input type="submit" value="Save Change">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
