/*
--------------------------------
    : Custom - Validate js :
--------------------------------
*/
"use strict";
$(document).ready(function() {
    jQuery(".form-validate").validate({
        ignore: [],
        errorClass: "invalid-feedback animated fadeInDown",
        errorElement: "div",
        errorPlacement: function(e, a) {
            jQuery(a).parents(".form-group > div").append(e)
        },
        highlight: function(e) {
            jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
        },
        success: function(e) {
            jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
        },
        rules: {
            "name": {
                required: !0,
                minlength: 3
            },
            "email": {
                required: !0,
                email: !0
            },
            "city": {
                required: !0,
            },
            "location": {
                required: !0
            },
            "coaching_class": {
                required: !0,
                minlength: 1
            },
            "specification": {
                required: !0
            },
            "skill": {
                required: !0
            },
            "timing": {
                required: !0
            },
            "digits": {
                required: !0,
                digits: !0
            },
            "mobile": {
                required: !0,
                digits: !0
            },
            "address": {
                required: !0
            },
            "description": {
                required: !0
            },
            "facality_name": {
                required: !0
            },
            "his_details": {
                required: !0
            },
           
        },
        messages: {
            "name": {
                required: "Please enter a coaching name",
                minlength: "Your username must consist of at least 3 characters"
            },
            "email": "Please enter a valid email address",
            "city": "Please select city",
            "confirm-password": {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            "mobile":{
                required: "Please enter mobile number",
                minlength: "atleast 10 digit want for mobile number"
            },
           
            "description": "Please enter description",
            "skill": "Please select a city!",
            "location": "Please select location!",
            "coaching_class": "Please select class!",
            "address": "Please enter a address!",
            "specification": "Please select subjects!",
            "timing": "Please enter coaching timing!",
            "his_details":"Please enter facality details",
            "facality_name":"Please enter facality name"
        }
    })   
});

$("#email").submit(function(){
    
    $.ajax({
        url:'emailupdate',
        type:'POST',
        data:$("#email").serialize(),
        dataType:'json',
        beforeSend:function(){
            $("button").prop("disabled",true);
            $("button").html('Loading...');
        },
        success:function(result){
            $("button").prop("disabled",false);
            $("button").html('Update');
            if(result.error){
                $.each(result.error,function(key,value){
                    if(key!=''){
                        $("#e-"+key).html(value).css('color','red');
                    }else{
                        $("#e-"+key).html('').css('color','#fff');
                    }
                });
            }else if(result.wrong){
                if(result.wrong.success==0){
                        $("#errorMsg").html(result.wrong.msg).css('color','red');
                }else{
                    $("#errorMsg").html(result.wrong.msg).css('color','green');
                }
            }

        },
        error:function(){
            $("button").prop("disabled",true);
            $("button").html('Loading...');
            $("#errorMsg").html('Please check internet connection or refresh your browser').css('color','red');
        }
    });
    return false;
});
$("#password").submit(function(){
    
    $.ajax({
        url:'passwordupdate',
        type:'POST',
        data:$("#password").serialize(),
        dataType:'json',
        beforeSend:function(){
            $("button").prop("disabled",true);
            $("button").html('Loading...');
        },
        success:function(result){
            $("button").prop("disabled",false);
            $("button").html('Update');
            if(result.error){
                $.each(result.error,function(key,value){
                    if(key!=''){
                        $("#p-"+key).html(value).css('color','red');
                    }else{
                        $("#p-"+key).html('').css('color','#fff');
                    }
                });
            } if(!result.error){
                $("#p-").html('');
            } if(result.wrong){
              
                if(result.wrong.success==0){
              
                        $("#perrorMsg").html(result.wrong.msg).css('color','red');
                }else{
              
                    $("#perrorMsg").html(result.wrong.msg).css('color','green');
                }
            }

        },
        error:function(){
            $("button").prop("disabled",true);
            $("button").html('Loading...');
            $("#errorMsg").html('Please check internet connection or refresh your browser').css('color','red');
        }
    });
    return false;
});

$("#update").submit(function(){
        $.ajax({
            url:'updateLoction',
            type:'POST',
            data:$("#update").serialize(),
            dataType:'json',
            beforeSend:function(){},
            success:function(result){

            },
            error:function(){}
        });
    return false;
});