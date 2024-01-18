<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Tol | Payment</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminLTE')}}/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('adminLTE')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminLTE')}}/dist/css/adminlte.min.css">

    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript" src="{{config('midtrans.snap_url')}}"
        data-client-key="{{config('midtrans.client_key')}}"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>{{$topup->inv_no}}</b></a>
            </div>
            <div class="card-body">
                <h3>Total Topup: <b>{{rupiah($topup->total)}}</b></h3>
                <h3>Status: <b>{{$topup->status}}</b></h3>
                <div class="text-center mt-4 mb-2">
                    <button type="button" id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{asset('adminLTE')}}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('adminLTE')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('adminLTE')}}/dist/js/adminlte.min.js"></script>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{$topup->payment_token}}', {
                onSuccess: function (result) {
                    location.reload();
                },
                onPending: function (result) {
                    alert("wating your payment!");
                },
                onError: function (result) {
                    alert("payment failed!");
                    location.reload();
                },
                onClose: function () {
                    location.reload();
                }
            })
        });
    </script>
</body>

</html>
