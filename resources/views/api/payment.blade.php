<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Tol | Payment</title>

    <script type="text/javascript" src="{{config('midtrans.snap_url')}}" data-client-key="{{config('midtrans.client_key')}}"></script>
</head>

<body>
    <script type="text/javascript">
        window.snap.pay('{{$token}}', {
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
    </script>
</body>

</html>
