<?php
if(Auth::id() != 1)
    die();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
        <meta charset="utf-8">
        <title>ورزشگاه های تایید نشده</title>
        <style>
            .title{
                display: block;
                width: 90%;
                margin: 10px auto;
                font-size: large;
                text-align: center;
            }
            .new_complex{
                display: flex;
                width: 90%;
                margin: 10px auto;
                font-size: large;
                text-align: center;
            }
            .new_complex input, .new_complex button{
                display: block;
                width: 23%;
                margin: 10px auto;
                font-size: large;
                text-align: center;
                border: solid;
            }
            #complexes{
                display: block;
                width: 100%;
            }
            .complex{
                display: inline-flex;
                width: 45%;
                margin: 10px 3.33% 10px 0;
                text-decoration: none;
                background: #eee;
            }
            .complex:hover{
                background: #fff;
            }
            .complex p, .complex button{
                display: inline-block;
                width: 100%;
                padding: 10px 0;
                font-size: large;
                text-align: center;
            }
        </style>
</head>
<body>
@include('header')
    <p class="title">لیست ورزشگاه‌های تایید نشده</p>
    <div id="complexes"></div>
    @include('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

show_complexes();
function show_complexes(){
    $.get('/get_all_complexes', function(data) {
        document.getElementById("complexes").innerHTML = "";
        for (var i = data.length-1; i >= 0 ; i--) {
            const newLink = document.createElement("div");
            newLink.className = "complex";
            newLink.innerHTML = "";
            newLink.innerHTML += '<p>نام: '+data[i].name+'</p>';
            newLink.innerHTML += '<p>شماره: '+data[i].phone+'</p>';
            newLink.innerHTML += '<p>ایمیل: '+data[i].email+'</p>';
            newLink.innerHTML += '<button onclick="delete_complex('+data[i].id+')">حذف</button>';
            if(data[i].verify == true)
                newLink.innerHTML += '<button onclick="change_verify('+data[i].id+',0)">رد تایید</button>';
            else
                newLink.innerHTML += '<button onclick="change_verify('+data[i].id+',1)">تایید</button>';
            document.getElementById("complexes").appendChild(newLink);
        }
    });
}

function delete_complex(id){
    if (confirm("آیا میخواهید این ورزشگاه و تمام سالن ها و .. را حذف کنید؟")) {
    $.ajax({
        url: '/delete_complex',
        type: 'post',
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
            alert(data);
            show_complexes();
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
    }
}

function change_verify(id,v){
            $.ajax({
                url: '/update_verify',
                type: 'POST',
                data: {
                    id: id,
                    verify: v,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response);
                    show_complexes();
                },
            });
}

check();
function check(){
    show_complexes();
    setTimeout(show_complexes, 5000);
}
</script>
</body>
</html>