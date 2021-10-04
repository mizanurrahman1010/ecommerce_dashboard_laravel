const isValidStep = (activePanelNum, eventTarget, DOMstrings) => {
    //alert(activePanelNum+" data ");
    if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
        activePanelNum--;
        setActiveStep(activePanelNum);
        setActivePanel(activePanelNum);
    } else if (activePanelNum == '0') { //is cart exist...
        isCartExist(function (data) {
            if (data.total <= 0) {
                Swal.fire({
                    title: 'Your Cart is Empty ..Please add some product!! ',
                    width: 600,
                    padding: '3em',
                    background: '#fff url(/images/trees.png)',
                    backdrop: `
                      rgba(0,0,123,0.4)
                      url("/images/nyan-cat.gif")
                      left top
                      no-repeat
                    `
                })
            } else {
                isActiveNextStep(activePanelNum, eventTarget, DOMstrings);
            }
        });
    } else if (activePanelNum == '1') {
        let name = $("#firstname").val();
        let lastname = $("#lastname").val();
        let address = $("#txt_cart_address").val();
        let email = $("#email").val();
        let phonenumber = $("#phonenumber").val();
        let postcode = $("#postcode").val();


        if (name == '')
            Swal.fire({
                title: 'First name cannot be null!!',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            })
        else if (address == '')
            Swal.fire({
                title: 'Address cannot be null!!',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            })
        else if (lastname == '')
            Swal.fire({
                title: 'Last name cannot be null!!',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            })
        else if (email == '')
            Swal.fire({
                title: 'Email cannot be null!!',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            })
        else if (postcode == '')
            Swal.fire({
                title: 'Post code cannot be null!!',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            })
        else if (phonenumber == '')
            Swal.fire({
                title: 'Phone number cannot be null!!',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            })
        else {
            isActiveNextStep(activePanelNum, eventTarget, DOMstrings);

        }
    } else if (activePanelNum == '2') {
        var payment_type = $(".div_payment_radio input[type='radio']:checked").val();
        isActiveNextStep(activePanelNum, eventTarget, DOMstrings);

    }
}

function isCartExist(callback) {
    const method = "GET";
    const url = "./isCartExist";
    const data = {};
    ajaxSetup(function (data) {
        callback(data);

    }, method, url, data);
}



function orderCheckout(v) {

    let name = $("#firstname").val();
    let address = $("#txt_cart_address").val();
    let email = $("#email").val();
    let lastname = $("#lastname").val();
    let phonenumber = $("#phonenumber").val();
    let alphonenumber = $("#alphonenumber").val();


    // let postcode=$("#postcode").val();
    let status = $("#status").val();
    let payment = $('input[name="payment_type"]:checked').val();
    let cardname = $("#card-name").val();
    let cardno = $("#card-no").val();
    let expireDate = $("#expiredate").val();
    let security_number=$("#sec-no").val();
    let comment = $("#comment").val();

    isCartExist(function (data) {
        if (data.total <= 0) {
            // alert("Cart is empty..");
            Swal.fire({
                title: 'Your Cart is Empty ..Please add some product!! ',
                width: 600,
                padding: '3em',
                background: '#fff url(/images/trees.png)',
                backdrop: `
                      rgba(0,0,123,0.4)
                      url("/images/nyan-cat.gif")
                      left top
                      no-repeat
                    `
            })
        } else {
            // alert(lastname);
            $.ajax({
                type: 'POST',
                //dataType: 'json',
                url: "./confim-order",
                data: {
                    name: name,
                    lastname: lastname,
                    phonenumber: phonenumber,
                    alphonenumber: alphonenumber,
                    status: status,
                    payment,
                    expireDate: expireDate,
                    comment: comment,
                    cardname: cardname,
                    cardno: cardno
                },
                success: function (data) {
                    let timerInterval
                    Swal.fire({
                        title: 'Your order created successfully!!',
                        html: 'We will close in <b></b> milliseconds.',
                        timer: 3000,
                        timerProgressBar: true,
                        onBeforeOpen: () => {

                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                                const content = Swal.getContent()
                                if (content) {
                                    const b = content.querySelector('b')
                                    if (b) {
                                        b.textContent = Swal.getTimerLeft()
                                    }
                                }
                            }, 100)
                        },
                        //   onClose: () => {
                        //     clearInterval(timerInterval),

                        //   }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('We was closed by the timer')
                        }
                    })
                }
            });
        }
    });


}



function increaseValue(v) {


    let id = $(v).attr("data-id");
    let value = parseInt(document.getElementById('qty-' + id).value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('qty-' + id).value = value;
    let rowId = $("#rowId-" + id).val();
    let qty = $("#qty-" + id).val();





    $(".btn_loading").attr("disabled", true);
    $(".cart_loading").text("Loading..");

    $.ajax({
        url: '/update-cart',
        type: 'GET',
        dataType: 'json',
        data: {increment: true, qty: qty, rowId: rowId},
        success: function (data) {

            updateCartInfo(data);
            $(".btn_loading").attr("disabled", false);
            $(".cart_loading").text("");
        }
    });




}

function decreaseValue(v) {

    var k = $(v).closest('.add-to-cart-btns');
    let id = $(v).attr("data-id");

    let value = parseInt(document.getElementById('qty-' + id).value);

    value = isNaN(value) ? 0 : value;
    value < 1 ? value = 1 : '';
    value--;
    document.getElementById('qty-' + id).value = value;

    let rowId = $("#rowId-" + id).val();
    let qty = $("#qty-" + id).val();

    $.ajax({
        url: '/update-cart',
        type: 'GET',
        dataType: 'json',
        data: {increment: true, qty: qty, rowId: rowId},
        success: function (data) {
            if (qty <= 0)
                $(".tr-" + rowId).remove();
                k.html('');
                k.html()

            updateCartInfo(data);
        }
    });



}

function deleteCart(v) {
    let id = $(v).attr("data-id");

    $(".btn_loading").attr("disabled", true);
    $(".cart_loading").text("Loading..");
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: "./delete-cart/" + id,
        data: {id: id},
        success: function (data) {


            $(".btn_loading").attr("disabled", false);
            $(".cart_loading").text("");


            $(".tr-" + id).remove();
            updateCartInfo(data);

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Cart Removed Successfully!!'
            })


        }
    });
    /*$("#navbarSupportedContent").load(" #navbarSupportedContent > *");
    $("#here").load(" #here > *");*/
}

function updateCartInfo(data) {



    $(".cart_qty").text(data.count);
    var gross_discount = 0;
    var gross_amount = 0;
    $.each(data.list, function (key, val) {
        var discount = 0;
        var amount = val.price * val.qty;
        if (val.options.discount != null && val.options.discount > 0)
            discount = (val.options.discount) * val.qty;
        else {
            var dis_amt = ((amount) * val.options.percent) / 100;
            discount = dis_amt;
        }
        var sub_amount = parseFloat(amount) - parseFloat(discount);
        gross_amount = parseFloat(gross_amount) + parseFloat(amount);
        $(".amount-" + val.rowId).text(amount + " BDT");

        $(".sub_amount-" + val.rowId).text(sub_amount + " BDT");

    });

    $(".final_amount_before").text(gross_amount);
}



function addToCart(v) {
    $('#cart-loading').show('fast');

    // sending to controller
    let id = $(v).attr("data-id");
    let qty = $("#qty-" + id).val();

    // var btn_txt = $(v).html();
    var placeofbtn = $(v).closest('.add-to-cart-btns');
    $(v).closest('.add-to-cart-btns').html('');

    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: "/add-to-cart",
        data: {id: id, qty: qty},
        success: function (data) {
            $(".cart_qty").text(data.count);
            placeofbtn.html(data.inc_dec_btn);
            $('#cart-loading').hide('fast');

            $("#sina-alert").addClass( "alert-success" ).text("added to cart").show('slow');
            window.setTimeout(function() {
                $("#sina-alert").hide("slow").removeClass( "alert-success" ).text("");
            }, 2000);

        }
    });

}



function increaseQty() {
    let value = parseInt(document.getElementById('qty').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('qty').value = value;
}

function decreaseQty() {
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    value < 1 ? value = 1 : '';
    value--;
    document.getElementById('number').value = value;
}

const isActiveNextStep = (activePanelNum, eventTarget, DOMstrings) => {
    if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
        activePanelNum--;
    } else {
        activePanelNum++;
    }
    setActiveStep(activePanelNum);
    setActivePanel(activePanelNum);
}


$(document).ready(function () {


    $('#clientInfo').click(function () {
        // alert("hello");

        $.ajax({
            type: "GET",
            url: "./getclientInfo",
            success: function (results) {
                //  console.log(results);
                $("#firstname").val(results.first_name);
                $("#lastname").val(results.last_name);
                $("#email").val(results.email);
                $("#txt_cart_address").val(results.present_address);
                $("#phonenumber").val(results.contact_no);
            }
        });
    });

    // Remove Items From Cart
    $('a.remove').click(function () {
        event.preventDefault();
        $(this).parent().parent().parent().hide(400);

    })

// Just for testing, show all items
    $('a.btn.continue').click(function () {
        $('li.items').show(400);
    })
});

// multi stepper form






