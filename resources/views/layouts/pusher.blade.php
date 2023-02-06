<!-- JAVASCRIPT
<script src="//js.pusher.com/3.1/pusher.min.js"></script>



-->
<link href="{{ URL::asset('/css/jquery.toast.css?v2.4') }}" rel="stylesheet" type="text/css" />

<script src="{{ URL::asset('/js/jquery.toast.js') }}"></script>
<script type="text/javascript">

//     var notificationsWrapper   = $('.dropdown-notifications');

// //   var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');

// //   var notificationsCountElem = notificationsToggle.find('i[data-count]');

//     var notificationsCount     = parseInt($('.notif-count').data('count'));

//     var notifications          = notificationsWrapper.find('div[data-notif]');

//     // var audio = document.getElementById("notif");

//     // if (notificationsCount <= 0) {

//     // notificationsWrapper.hide();

//     // }



//     // Enable pusher logging - don't include this in production

//     // Pusher.logToConsole = true;



//     var pusher = new Pusher('4af297e166b09177773e', {

//         cluster: 'ap1',

//         encrypted: true

//     });



//     // Subscribe to the channel we specified in our Laravel Event

//     var id = "{{Session::get('id')}}";

//     var channel = pusher.subscribe('notification'+id);

//     // console.log(notificationsCount);



//     // Bind a function to a Event (the full Laravel class)

//     channel.bind('App\\Events\\Notification', function(data) {

    

//     var existingNotifications = notifications.html();

//     var newNotificationHtml = `

//     <div class="item" data-simplebar style="max-height: 230px;">    

//         <a href="{{url('')}}/`+data.url+`" class="text-reset notification-item">

//             <div class="media">

//                 <div class="avatar-xs me-3">

//                     <span class="avatar-title bg-primary rounded-circle font-size-16">

//                         <i class="bx bxs-notification"></i>

//                     </span>

//                 </div>

//                 <div class="media-body">

//                     <h6 class="mt-0 mb-1" key="t-your-order">`+data.judul+`</h6>

//                     <div class="font-size-12 text-muted">

//                         <p class="mb-1" key="t-grammer">`+data.pesan+`</p>

//                         <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">`+data.date+`</span></p>

//                     </div>

//                 </div>

//             </div>

//         </a>

//     </div>

//     `;

//     if(notificationsCount === 0){
//         notifications.html(newNotificationHtml);
//     }
//     else{
//         notifications.html(newNotificationHtml + existingNotifications);
//     }

//     notificationsCount+=1;

//     $('.notif-count').text(notificationsCount);

//     // audio.currentTime = 0;

//     // audio.play();

//     // notificationsWrapper.show();

//     });

$('.btnNotif').on('click', function(){
    console.log('a');

$.ajax({

        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        url: '/mark-read', 

        type: 'POST',

        success: function(response) {

            $('.notif-count').text(0);

            notificationsCount = 0;

        },

        error: function(xhr, status, error) {

          var err = eval("(" + xhr.responseText + ")");

          console.log(xhr);

        }

    });

}); 


$('.myForm').on('submit', function () {
    $('.submit').attr('disabled', 'disabled');
});

$('.file-upload').on('change', function() {
    
    const size = 
        (this.files[0].size / 1024 / 1024).toFixed(2);

    if (size > 5) {
        $.toast({
            heading: 'Gagal',
            text: 'ukuran file maksimal 2mb',
            showHideTransition: 'plain',
            icon: 'error',
            position: 'top-right',
            stack:false,
        });
        $(this).val('');
    } 
});
   

</script>