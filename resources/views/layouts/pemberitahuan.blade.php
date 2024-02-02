<div class="dropdown d-inline-block">
    <button type="button" class="btn btnNotif header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bx bx-bell bx-tada"></i>
        <span class="badge bg-danger rounded-pill notif-count" data-count="{{$count}}">{{$count}}</span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 dropdown-notifications"
        aria-labelledby="page-header-notifications-dropdown">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0" key="t-notifications"> Pemberitahuan </h6>
                </div>
                <div class="col-auto">
                    <a href="{{url('pemberitahuan')}}" class="small" key="t-view-all"> Lihat Semua</a>
                </div>
            </div>
        </div>
        <div data-notif>
        @if(!$pemberitahuan->isEmpty())
        @foreach($pemberitahuan as $row)

            <div class="item" data-simplebar style="max-height: 230px;">
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
                                <!-- <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">{{$row->updated_at->format('d-m-Y H:i:s')}}</span></p> -->
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        @endforeach
        @else
            <div class="text-center pb-4 pt-4">
                <p>Tidak ada pemberitahuan</p>
            </div>
        @endif
        </div>
        <div class="p-2 border-top d-grid">
            <a class="btn btn-sm btn-link font-size-14 text-center" href="{{url('pemberitahuan')}}">
                <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">Lihat Semua</span> 
            </a>
        </div>
    </div>
</div>
