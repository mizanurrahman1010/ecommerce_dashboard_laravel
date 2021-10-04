<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script>
    var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
        cluster: '{{env("PUSHER_APP_CLUSTER")}}',
        encrypted: true
    });

    var link = "{{route('owner.order.all')}}";
    var channel = pusher.subscribe('order-channel');
    channel.bind('App\\Events\\Order', function(data) {
        // alert(data.message);
        $('#order_push_notifications').append(
            '<a href="'+link+'">'+
            '<div class="alert alert-success alert-dismissible fade show" role="alert" style="display: absolute; right: 0; bottom: 0;">'+
                '<strong>New Order </strong><br>'+
                    'Customer Name: '+data.customer_name+
                    '<br>Mobile: '+data.mobile+
                    '<br>Address: '+data.address+
                    '<br>Total: '+data.total+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                    '<span aria-hidden="true">&times;</span>'+
                '</button>'+
            '</div>'+
            '</a>'
        );
    });
</script>
