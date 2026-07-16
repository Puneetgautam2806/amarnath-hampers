@include('backoffice.common_inc.header')
@include('backoffice.common_inc.menu')
@include('backoffice.common_inc.top')
<div class="container-xxl flex-grow-1 container-p-y">
    @hasSection('content')
        @yield('content')
    @else
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Welcome to the Backoffice</h5>
                        <p class="card-text">No Content Found !!</p>  
                    </div>
                </div>
            </div>
        </div>

        
    @endif
   
</div>
@include('backoffice.common_inc.footer')