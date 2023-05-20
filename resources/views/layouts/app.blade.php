<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vacation Manager') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- START BOOTSTRAP -->
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    {{-- jquery-ui --}}
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-1.8.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.js') }}"></script>
    <link href="{{ asset('assets/js/jquery-ui/jquery-ui.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/gritter/css/jquery.gritter.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lineicons/style.css') }}">
    
    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style-responsive.css') }}" rel="stylesheet">

    <!-- END BOOTSTRAP -->

    {{-- START PUSHER --}}
    <script src="{{ asset('assets/js/pusher.min.js') }}"></script>
    <script src="{{ asset('assets/js/echo.iife.js') }}"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        @if (auth()->user())
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: '{{ env('PUSHER_APP_KEY') }}',
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: 'true',
                authEndpoint: '{{ asset('broadcasting/auth') }}',
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                }
            })
            // // for public channel
            /*Echo.channel('notification.' + {{ auth()->user()->id }})*/
            Echo.private('notification.' + {{ auth()->user()->id }})
                .listen('.vacation-event', function(data) {
                    this.fetchNotification()
                    sidebarNotification(data);
                })
        @endif

        fetchNotification()

        function fetchNotification(){
            $.ajax({
                type: "GET",
                url: "{{url('api/fetchnotification')}}",
                dataType: "json",
                success: function(response){
                    navbarNotification(response);
                }
            })
        }

        function navbarNotification(response){

            let notificationNav = `
                <a data-toggle="dropdown" class="dropdown-toggle" id="notification">
                    ${(response.count > 0) ? `<i class="fa fa-bell"></i><span class="badge bg-theme" id="notification_num">${response.count}</span>` : `<i class="fa fa-bell-o"></i>`}
                </a>
                <ul class="dropdown-menu extended inbox">
                    ${(response.count >= 0) ? `<li><p class="green">You have ${response.count} pending vacations</p></li>` : `<li><p class="green">You don't have pending vacations</p></li>`}
            `;
            if (response.count >= 0) {
                response.notifications.forEach(element => {

                notificationNav += `
                    <li>
                        <p style="background-color: white; cursor: pointer;" onmouseover="this.style.backgroundColor='#F0F0F0'" onmouseout="this.style.backgroundColor='white'" onclick="window.location.href='{{ url('vacation/${element.data.vacation_id}/edit') }}'">${element.data.data}</p>
                    </li>
                `;
                });
            }

            notificationNav += `
                    <li>
                        <a href="{{ route('vacation' , 'all') }}">See all vacations</a>
                    </li>
                </ul>
            `;
            $('#header_inbox_bar').html(notificationNav);
        }

        function sidebarNotification(response){
                let notificationWindow =`
                <div class="p-3 mb-2 bg-primary text-white" aria-live="polite" aria-atomic="true" style="padding: 10px">
                    <div>
                        <div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
                            <div class="toast-header">
                                <svg width="20" height="20" class="mr-2" viewBox="0 0 24 24">
                                    <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M11,16.5L18,9.5L16.59,8.09L11,13.67L7.91,10.59L6.5,12L11,16.5Z" fill="#ccc"></path>
                                </svg>
                                <strong class="mr-auto">${response.message}</strong>
                                <small>just now</small>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                $('#notification-box').html(notificationWindow);
                
            setTimeout(() => {
                try {
                    $('#notification-box').removeClass("col-lg-3 ds").text('');
                } catch (error) {
                    //console.log(error);
                }
            }, 4000);
        }

    </script>
    {{-- END PUSHER --}}

</head>
<body>

    <div id="app">

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- START BOOTSTRAP -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script class="include" type="text/javascript" src="{{ asset('assets/js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.sparkline.js') }}"></script>


    <!--common script for all pages-->
    <script src="{{ asset('assets/js/common-scripts.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('assets/js/gritter/js/jquery.gritter.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/gritter-conf.js') }}"></script>

</body>
</html>
