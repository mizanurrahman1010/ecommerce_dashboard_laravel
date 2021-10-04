// var errorsHtml="";
// res.errors.map(e=>{
//     errorsHtml+="<li>"+e.msg+"</li>"
// });
// var errors="<ul>"+errorsHtml+"</ul>";
// var alertData={icon:'error',html:errors,title:res.msg};
// sweetAlert(alertData);
$(document).ready(function() 
{
    $('.jqSelect2').select2();
});
$(document).on("click",".global-checkbox",function(){
    if($(this).is(":checked"))
        $(".g-input-checkbox").prop("checked",true);
    else
        $(".g-input-checkbox").prop("checked",false);
});
function ajaxCustom(callback, method, url, data) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: method,
        dataType: 'json',
        url: url,
        data: data,
        success: function (data) {
            callback(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //alert("Server Error");
            if (jqXHR.status === 0) {
                alert('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Requested page not found.');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error.');
            } else if (errorThrown === 'parsererror') {
                alert('Requested JSON parse failed');
            } else if (errorThrown === 'timeout') {
                alert('Time out error');
            } else if (errorThrown === 'abort') {
                alert('Ajax request aborted ');
            } else {
                alert('Uncaught Error.\n' + jqXHR.responseText);
            }
        }
    });

}
function sweetAlert(obj) {

    var defIcon="success";
    var defPosition="top-end";var defShowConfirmButton=false;
    if(typeof obj.position != 'undefined' )
        defPosition=obj.position;
    if(typeof obj.showConfirmButton != 'undefined' )
        defShowConfirmButton=obj.showConfirmButton;

    var data={
        position: defPosition,
        //icon: defIcon,
        showConfirmButton: defShowConfirmButton,

    };
    if(typeof obj.toast != 'undefined')
        data.toast=obj.toast;

    if(typeof obj.aoc != 'undefined')
        data.allowOutsideClick=obj.aoc;

    if(typeof obj.timer != 'undefined')
        data.timer=obj.timer;
    if(typeof obj.html != 'undefined')
        data.html=obj.html;
    if(typeof obj.title != 'undefined')
        data.title=obj.title;
    if(typeof obj.tpb != 'undefined')
        data.timerProgressBar=obj.tpb;
    if(typeof obj.icon != 'undefined')
        data.icon=obj.icon;
    if(typeof obj.showLoading != 'undefined'){
        data.didOpen= () => {
            Swal.showLoading()
        };
    }
    Swal.fire(data);
}
