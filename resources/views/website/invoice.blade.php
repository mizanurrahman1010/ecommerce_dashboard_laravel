<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" media="print" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" media="print" href="{{asset('css')}}/assets/print.css">
    <link rel="stylesheet" media="screen" href="{{asset('css')}}/assets/print.css">
</head>
<body>

    <div id='printarea'>
        <h1 class="bg-success text-white pl-3" >INVOICE</h1>

        <div class="d-flex mb-4">
            <div class="col-6 px-0">
                <h4>From</h4>
                <p class="mb-0">Name: {{$site_setting->name}}</p>
                <p class="mb-0">Mobile: {{$site_setting->phone}}</p>
                <p class="mb-0">Address: {{$site_setting->address}}</p>

            </div>
            <div class="col-6 px-0">
                <h4>To</h4>
                <p class="mb-0">Name: {{$user_info->name}}</p>
                <p class="mb-0">Address: {{$invoice->address}}</p>
                <p class="mb-0">Note: {{$invoice->note}}</p>

            </div>
        </div>

    <table id="customers">
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>


        @foreach ($invoice->get_order_details as $i)
            <tr>
                <td>{{$i->get_product_name->name}}</td>
                <td>{{$i->quantity}}</td>
                <td>{{$i->price}}</td>
                <td>{{ $i->quantity * $i->price }}</td>
            </tr>
        @endforeach

        <tr>
            <td style="border-bottom: none !important; border-top: none !important; border-left: none !important;" colspan="2"></td>
            <td>Sub Total</td>
            <td>{{$invoice->total}}</td>
        </tr>
        <tr>
            <td style="border-bottom: none !important;  border-top: none !important; border-left: none !important;" colspan="2"></td>
            <td>Shipping Cost </td>
            <td>{{$invoice->shipping_cost}} </td>
        </tr>

        <tr>
        <td style="border-bottom: none !important;  border-top: none !important; border-left: none !important;" colspan="2"></td>
            <td><b>Total</b> </td>
            <td><b>{{$invoice->total + $invoice->shipping_cost}}</b> </td>
        </tr>


  </table>

    </div>

    <input style="position: fixed; top:1px; right:1px;" class="hide-print btn btn-warning" type='button' id='btn' value='Print'>
    <button onclick="goBack()" style="position: fixed; top:1px; right:100px;" class="hide-print btn btn-warning">Go Back</button>

<script>
function goBack() {
  window.history.back();
}
</script>





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script>

        $("#btn").click(function () {
            $(".hide-print").hide();
    //Hide all other elements other than printarea.
    $("#printarea").show();
    window.print();
    $(".hide-print").show();
        });
    </script>
</body>
</html>
