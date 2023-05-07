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
                    alert( data )
                    console.log( 'data', data )
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
                    sidebarNotification(response);
                }
            })
        }

        function navbarNotification(response){

            let notificationNav = `
            
            <a data-toggle="dropdown" class="dropdown-toggle" id="notification">
                ${(response.count > 0) ? `<i class="fa fa-bell"></i><span class="badge bg-theme" id="notification_num">${response.count}</span>` : `<i class="fa fa-bell-o"></i>`}
            </a>
            
            <ul class="dropdown-menu extended inbox">
                <div class="notify-arrow notify-arrow-green"></div>

                ${(response.count >= 0) ? `<li><p class="green">You have ${response.count} pending vacations</p></li>` : `<li><p class="green">You don't have pending vacations</p></li>`}

            `;
            if (response.count >= 0) {
                response.notifications.forEach(element => {

                const str = element.created_at;
                const [dateValue, timeValue] = str.split('T');

                if ((element.admin_read == 1 && element.employee_read == 0) || (element.manager_read == 1 && element.employee_read == 0) ) {
                    
                    let message = ''
                    if (element.status_id == 2) {
                        message = ' has been approved'
                    } else if(element.status_id == 3){
                        message = ' has been not approved'
                    }
                    notificationNav += `
                        <li>
                            <a href="{{ route('vacation', 'all') }}">
                                <span class="subject">
                                    <span class="from">Your request created ${dateValue}</span>
                                </span>
                                <span class="subject">
                                    <span class="from">${message}</span>
                                </span>
                            </a>
                        </li>
                    `;
                } else{
                    notificationNav += `
                        <li>
                            <a href="{{ url('vacation/${element.id}/edit') }}">
                                <span class="subject">
                                <span class="from">${element.user.name} ${element.user.last_name} send request</span>
                                </span>
                                <span class="subject">
                                <span class="from">created ${dateValue}</span>
                                </span>
                            </a>
                        </li>
                    `;
                }

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
            //  because it doesn't needs to be displayed if there is no notifications
            if (response.notifications.length > 0) {
                
                let notificationWindow = '<h3>NOTIFICATIONS</h3>';

                response.notifications.forEach(element => {

                    const str = element.created_at;
                    const [dateValue, timeValue] = str.split('T');

                    if ((element.admin_read == 1 && element.employee_read == 0) || (element.manager_read == 1 && element.employee_read == 0) ) {
                        let message = ''
                        if (element.status_id == 2) {
                            message = `Your request created ${dateValue} has been approved`
                        } else if(element.status_id == 3){
                            message = `Your request created ${dateValue} has been not approved`
                        }
                        notificationWindow += `
                            <a href="{{ route('vacation', 'all') }}">
                                <div class="desc">
                                    <div class="details">
                                        <p style="font-size:12px;color:black;">${message}</p>
                                    </div>
                                </div>
                            </a>
                        `;
                    }else{
                        notificationWindow += `
                            <a href="{{ url('vacation/${element.id}/edit') }}">
                                <div class="desc">
                                    <div class="details">
                                        <p style="font-size:12px;color:black;">${element.user.name} ${element.user.last_name} send request</p>
                                        <p style="font-size:12px;color:black;">created ${dateValue}</p>
                                    </div>
                                </div>
                            </a>
                        `;
                    }

                });

                $('#notification-box').addClass("col-lg-3 ds").html(notificationWindow);
            }

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
