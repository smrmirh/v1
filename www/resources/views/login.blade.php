<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الوپد ::‌ ورود</title>
    <link rel="stylesheet" href="/assets/css/bootstrap-4.3.1.min.css">
    <link rel="stylesheet" href="/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="/assets/css/login.css?0.1">
</head>
<body>
<section class="min-vh-100">
    <div class="row p-0 m-0 h-100">
        <div class="col-12 col-md-4 h-100 form-side">
            <div class="row d-flex flex-column  ">
                <div class="col-12 col-md-12 p-3"></div>
                <div class="col-12 col-md-12 d-flex justify-content-center">
                    <div class="logo-container">
                        <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 439.69 516.66"><g id="Layer_4" data-name="Layer 4"><path d="M497.69,526.72,328,613.62a16.4,16.4,0,0,1-15,0L125.24,516.06a13.43,13.43,0,0,1-7.52-11.77l-.49-194.07a13.49,13.49,0,0,1,7.52-11.83L312.91,197.86a16.39,16.39,0,0,1,15.14,0l150.13,74.19a16.44,16.44,0,0,0,15.22,0l18-11.26c9.94-5.29,8.52-15.6-1.46-20.83L328,151.37a16.49,16.49,0,0,0-15.1,0L88.1,269.67a13.48,13.48,0,0,0-7.52,11.8V534a13.48,13.48,0,0,0,7.57,11.83L313,664.37a16.47,16.47,0,0,0,15.06,0l184.71-95.58a13.5,13.5,0,0,0,7.5-11.8V538.57C520.22,528.1,507.73,521.54,497.69,526.72Z" transform="translate(-80.58 -149.54)" style="fill:#8d9b9d"/><path d="M302.11,388.64,213.84,350V322.93a8.89,8.89,0,0,0-3.13-6.61c-2.29-2.22-4.38-2.79-6.21-2.28L141.73,331.6c-2.86.8-2.88,3.8,0,7.78,20.81,28.91,41.65,53.73,62.46,82.64,2,2.78,4.14,4.59,6.7,5s3-1.3,3-3.58V401.51l88.28,42.81a15.5,15.5,0,0,0,14.27,0l183.1-102.86a12.86,12.86,0,0,0,7.15-11.28v-20.5c0-10-11.91-16.3-21.43-11.28L316.38,388.62A15.47,15.47,0,0,1,302.11,388.64Z" transform="translate(-80.58 -149.54)" style="fill:#7eb742"/><path d="M363.22,477.21l-48,25.32a13,13,0,0,1-11.92,0L157.46,431c-8-4.19-18,1.11-17.88,9.51l.25,27.81a10.73,10.73,0,0,0,6,9.34l157.51,79.23a13,13,0,0,0,11.93,0L432,489.5v25.73c0,2.28.43,4,3,3.58s4.7-2.21,6.7-5q31.21-43.36,62.47-86.72c2.87-4,2.85-7,0-7.78q-31.39-8.81-62.79-17.57c-1.82-.51-3.84,0-6.21,2.29s-3.14,4.37-3.13,6.6v22.92l-68.49,43.56" transform="translate(-80.58 -149.54)" style="fill:#f25f5c"/></g></svg>
                    </div>
                </div>
                <div class="col-12 col-md-12 p-2">
                    <div class="container-fluid w-75 text-rtl text-right">
                        @foreach( $errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-12 m-auto">
                    <form action="" method="post" autocomplete="off">
                        @csrf
                        <div class="container-fluid w-75">
                            <div class="row border border-white p-1 bg-loginfield shadow shadow-sm">
                                <div class="col-10 col-md-10 p-1">
                                    <input type="text" class="form-control border-0" name="username" placeholder="نام کاربری..." tabindex="1" autofocus>
                                </div>
                                <div class="col-2 col-md-2 d-flex align-items-center justify-content-center text-info"><span class="fas fa-user fs-17em fc-loginfield"></span></div>
                            </div>
                            <div class="row mt-1 border border-white p-1 bg-loginfield shadow shadow-sm">
                                <div class="col-10 col-md-10 p-1">
                                    <input type="password" class="form-control border-0" name="password" placeholder="رمزعبور..." tabindex="2">
                                </div>
                                <div class="col-2 col-md-2 d-flex align-items-center justify-content-center text-info"><span class="fas fa-key fs-17em fc-loginfield"></span></div>
                            </div>
                            <div class="row mt-3">
                            </div>
                            <div class="row mt-3">
                                <button class="form-control btn btn-success w-50 m-auto" type="submit" tabindex="3">LOGIN</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="d-none d-md-block col-12 col-md-8 h-100 note-side">
        </div>
    </div>
</section>
</body>
</html>