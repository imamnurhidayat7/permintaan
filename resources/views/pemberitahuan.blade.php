@if(Session::get('role') == '')
    @php $dashboard = 'layouts.master'; @endphp
@elseif(Session::get('role') == 'pemohon')
    @php $dashboard = 'layouts.master'; @endphp
@else
    @php $dashboard = Session::get('role').'.master_'.Session::get('role'); @endphp
@endif

@extends($dashboard)

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Pemberitahuan</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">Pemberitahuan</a></li> -->
                    @if(isset($title))
                        <li class="breadcrumb-item active"></li>
                    @endif
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row mb-2">

    <div class="col-12">

    <div class="card mini-stats-wid">

        <div class="card-body">

            @foreach($pemberitahuan as $row)

            <div class="item" style="max-height: 230px;">

                <a href="{{url('')}}/{{$row->url}}" class="text-reset notification-item">

                    <div class="media">

                        <div class="avatar-xs me-3">

                            <span class="avatar-title bg-primary rounded-circle font-size-16">

                                <i class="bx bxs-notification"></i>

                            </span>

                        </div>

                        <div class="media-body">

                            <h6 class="mt-0 mb-1" key="t-your-order">{{$row->judul}}</h6>

                            <div class="font-size-12 text-muted">

                                <p class="mb-1" key="t-grammer">{{$row->pesan}}</p>

                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">{{$row->created_at->format('d-m-Y H:i:s')}}</span></p>

                            </div>

                        </div>

                    </div>

                </a>

            </div>

            @endforeach

        </div>

    </div>

    </div>

    </div>
                
@endsection
    
    