/*
-----------------------------
    : Custom - Chat js :
-----------------------------
*/
"use strict";
$(document).ready(function(){
    
            $("#musicCategory").submit(function(){
                var formdata = $("#musicCategory")[0];
                var data = new FormData(formdata); 
                $.ajax({
                    url:'add-music-category',
                    method: 'POST',
                    dataType: 'json',
                    data: data,
                    cache:false,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $("button").text('Loading...').attr('disabled', 'disabled');
                    },
                    success:function(result){
                        $("button").text('Submit').removeAttr('disabled');
                        if(result.success==0){
                            notification('error',result.msg);
                        }else{
                            notification('success',result.msg);
                            $('#musicCategory')[0].reset();
                        }
                    },
                    error:function(){
                        notification('error','Something went wrong , please contact to developer or support team');
                    }
            })
            return false;
        })

        /* ==================== music sub category================================ */
        $("#submusicCategory").submit(function(){
            var formdata = $("#submusicCategory")[0];
            var data = new FormData(formdata); 
            $.ajax({
                url:'add-music-sub-category',
                method: 'POST',
                dataType: 'json',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    $("button").text('Loading...').attr('disabled', 'disabled');
                },
                success:function(result){
                    $("button").text('Submit').removeAttr('disabled');
                    if(result.success==0){
                        notification('error',result.msg);
                    }else{
                        notification('success',result.msg);
                        $('#musicCategory')[0].reset();
                    }
                },
                error:function(){
                    notification('error','Something went wrong , please contact to developer or support team');
                }
        })
        return false;
    })
        /* ======================music sub category end=========================== */
        /* ==================== category music============================== */
            $("#musicItem").submit(function(){
                var formdata = $("#musicItem")[0];
                var data = new FormData(formdata); 
                $.ajax({
                    url:'create-music',
                    method: 'POST',
                    dataType: 'json',
                    data: data,
                    cache:false,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $("button").text('Loading...').attr('disabled', 'disabled');
                    },
                    success:function(result){
                        console.log(result);
                        $("button").text('Submit').removeAttr('disabled');
                        if(result.error){
                            $.each(result.error,function(key,value){

                                if(key!=''){
                                    $("#"+key).html(value);
                                }else{
                                    $("#"+key).html('');
                                }
                            });
                        }
                        if(result.success==0){
                            notification('error',result.msg);
                        }else if(result.success==1){
                            notification('success',result.msg);
                            $('#musicItem')[0].reset();
                        }
                        
                    },
                    error:function(){
                        notification('error','Something went wrong , please contact to developer or support team');
                    }
            })
            return false;
            });
        /* ========================category music end=====end=============== */
})


$("#category").change(function(){
    $.ajax({
        url:'getsub-categorylist',
        method:'POST',
        data:{id:this.value},
        dataType:'json',
        success:function(result){
            $("#subcate").html(result);
        }
    });
});


