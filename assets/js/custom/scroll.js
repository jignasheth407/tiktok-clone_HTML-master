/*
-----------------------------
    : Custom - Chat js :
-----------------------------
*/
"use strict";
$(document).ready(function(){
  
    //$("#showrt").trigger('click');
      var type = getUrlVars()["type"]!='' ? getUrlVars()["type"]: '';
     var sponsorid = getUrlVars()["id"]!='' ? getUrlVars()["id"] : '';
     var want = getUrlVars()["want"]!='' ? getUrlVars()["want"] : '';
    $(window).scroll(function(){
       
        var position = $(window).scrollTop();
        var bottom = $(document).height() - $(window).height();
        if( position == bottom ){
            var row = Number($('#row').val());
            var allcount = Number($('#all').val());
            var rowperpage = 3;
            console.log("row "+row+ " All count "+ allcount);
            row = row + rowperpage;
            console.log("new row "+row+ " All count "+ allcount);
            if(row <= allcount){
                $('#row').val(row);
                $.ajax({
                    url: 'next-video',
                    type: 'post',
                    data: {limit:row,type:type,sponsorid:sponsorid,want:want},
                    dataType:'json',
                    beforeSend:function(){},
                    success: function(response){
                        if(response.status){
                            $(".sud:last").after(response.data).show().fadeIn("slow");
                        }else{
                            alert('empty'); 
                        }
                    },error:function(){
                        alert('errr')
                    }
                });
            }
        }
    });
});

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
// $(".sud a").click(function(){
//     var link = this.href.split('javascript:;');
//     $.post('activation',{link},function(result){
//         notification(result.class,result.msg);
//     },'json');
// });
function update(event){
    //console.log(event.srcElement.id);
    var link = event.srcElement.href.split('javascript:;');
    $.post('activation',{link},function(result){
        notification(result.class,result.msg);
        $("#showbutton-"+result.id).attr('class',result.button).html(result.text);
    },'json');
}

function notification(type,message){
    var options = {
        autoClose: true,
        progressBar: true,
        enableSounds: true,
        sounds: {
            info: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233294/info.mp3",
            success: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233524/success.mp3",
            warning: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233563/warning.mp3",
            error: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233574/error.mp3",
        },
    };

    var toast = new Toasty(options);
    toast.configure(options);
    if(type=='success'){
        toast.success(message);
    }else if(type=='error'){
        toast.error(message);
    }
   
}

