<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <div class="header-button d-flex justify-content-end w-100">
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="d-flex align-items-center">
                                <div class="image me-2">
                                    <img src="{{asset('img/user.svg')}}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 40px; height: 40px;" />
                                </div>
                                <div class="content">
                                    <a class="js-acc-btn text-decoration-none" href="#">{{ Auth::user()->name }}</a>
                                </div>
                            </div>
                            <div class="account-dropdown js-dropdown position-absolute end-0 mt-2" style="min-width: 250px; z-index: 1000;">
                                <div class="info clearfix p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="image me-3">
                                            <a href="#">
                                                <img src="{{asset('img/user.svg')}}" alt="{{ Auth::user()->name }}" class="rounded-circle" style="width: 50px; height: 50px;" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h5 class="name mb-1">
                                                <a href="#" class="text-decoration-none">{{ Auth::user()->name }}</a>
                                            </h5>
                                            <span class="email text-muted">{{ Auth::user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="account-dropdown__body border-top">
                                    <div class="account-dropdown__item p-2">
                                        <a href="#" class="d-flex align-items-center text-decoration-none text-dark p-2">
                                            <i class="zmdi zmdi-account me-2"></i>Account
                                        </a>
                                    </div>
                                    <div class="account-dropdown__item p-2">
                                        <a href="#" class="d-flex align-items-center text-decoration-none text-dark p-2">
                                            <i class="zmdi zmdi-settings me-2"></i>Setting
                                        </a>
                                    </div>
                                    <div class="account-dropdown__item p-2">
                                        <a href="#" class="d-flex align-items-center text-decoration-none text-dark p-2">
                                            <i class="zmdi zmdi-money-box me-2"></i>Billing
                                        </a>
                                    </div>
                                </div> --}}
                                <div class="account-dropdown__footer border-top p-2">
                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" 
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="d-flex align-items-center text-decoration-none text-dark p-2">
                                            <i class="zmdi zmdi-power me-2"></i>
                                            <span>Logout</span>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>