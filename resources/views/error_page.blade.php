@if(Session::get('role') == '')
    @php $dashboard = 'layouts.master'; @endphp
@elseif(Session::get('role') == 'pemohon')
    @php $dashboard = 'layouts.master'; @endphp
@else
    @php $dashboard = Session::get('role').'.master_'.Session::get('role'); @endphp
@endif

@extends($dashboard)

@section('content')
<div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <h1 class="display-2 fw-medium">4<i class="bx bx-buoy bx-spin text-primary display-3"></i>3</h1>
                            <h4 class="text-uppercase">Maaf, anda tidak berhak mengakses halaman ini!</h4>
                            @if(Session::get('id') != null)
                            <div class="mt-5 text-center">
                                @if(Session::get('role') == 'customerservice')
                                <a class="btn btn-primary waves-effect waves-light" href="{{url('/')}}/cs/dashboard">Kembali ke Dashboard</a>
                                @else
                                <a class="btn btn-primary waves-effect waves-light" href="{{url('/')}}/{{Session::get('role')}}/dashboard">Kembali ke Dashboard</a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-xl-6">
                        <div>
                            <img src="{{url('')}}/images/error-img.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
@endsection
    