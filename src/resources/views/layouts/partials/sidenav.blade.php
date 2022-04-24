<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link text-white @if(request()->routeIs('fees.dashboard')) active bg-gradient-primary @endif " href="/fees">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-white @if(request()->routeIs('fees.structure.*')) active bg-gradient-primary @endif" href="{{route('fees.structure.index')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Fee Structure</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-white" href="./pages/billing.html">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">receipt_long</i>
            </div>
            <span class="nav-link-text ms-1">Billing</span>
        </a>
    </li>


    <!-- <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account</h6>
    </li>
    <li class="nav-item">
        <a class="nav-link text-white " href="{{'/fees/profile'}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
        </a>
    </li> -->
</ul>