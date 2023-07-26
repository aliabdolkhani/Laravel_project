<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
        <meta charset="utf-8">
        <title>my complexes</title>
        <style>
            .title{
                display: block;
                width: 90%;
                margin: 10px auto;
                font-size: large;
                text-align: center;
            }
            #new_complex{
                display: flex;
                width: 90%;
                margin: 10px auto;
                font-size: large;
                text-align: center;
            }
            #new_complex input, #new_complex button{
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
            .complex p{
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
    <p class="title">شما میتوانید ورزشگاه خود را اضافه کنید</p>
    <form class="new_complex" id="new_complex">
        <input id="name" name="name" placeholder="نام" type="text">
        <input id="phone" name="phone" placeholder="شماره" type="number">
        <input id="email" name="email" placeholder="ایمیل" type="text">
        <button type="submit">ثبت ورزشگاه</button>
    </form>
    <p class="title">لیست ورزشگاه‌های شما</p>
    <div id="complexes"></div>
    @include('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

$(function () {
    $('#new_complex').submit(function (event) {
        event.preventDefault();
        var v1 = document.getElementById("name").value;
        var v2 = document.getElementById("phone").value;
        var v3 = document.getElementById("email").value;
        if(v1 == "" || v2 == "" || v3 == ""){
            alert("تمام ورودی ها را وارد کنید");
        } else {
            $.ajax({
                url: '/add_complex',
                type: 'POST',
                data: {
                    name: v1,
                    phone: v2,
                    email: v3,
                    creator_id: {{Auth::id()}},
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response);
                },
            });
        }
    });
});

show_complexes();
function show_complexes(){
    $.get('/get_my_complexes', function(data) {
        document.getElementById("complexes").innerHTML = "";
        for (var i = data.length-1; i >= 0 ; i--) {
            const newLink = document.createElement("a");
            newLink.className = "complex";
            newLink.href = '<?php echo url('/complex?id='); ?>'+data[i].id;
            newLink.innerHTML = "";
            newLink.innerHTML += '<p>نام: '+data[i].name+'</p>';
            newLink.innerHTML += '<p>شماره: '+data[i].phone+'</p>';
            newLink.innerHTML += '<p>ایمیل: '+data[i].email+'</p>';
            document.getElementById("complexes").appendChild(newLink);
        }
    });
    setTimeout(show_complexes, 10000);
}

</script>
</body>
</html>