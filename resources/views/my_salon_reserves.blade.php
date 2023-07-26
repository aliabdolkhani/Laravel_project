<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
        <meta charset="utf-8">
        <title>رزروهای من</title>
        <style>
            body{
                margin: 0;
            }
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
                display: flex;
                width: 100%;
                margin: 10px 0;
                text-decoration: none;
                background: #eee;
            }
            .complex p{
                display: inline-block;
                width: 100%;
                padding: 10px 0;
                font-size: large;
                text-align: center;
            }
            .available_time{
                display: inline-flex;
                width: 45%;
                margin: 10px 3.33% 10px 0;
                text-decoration: none;
                background: #eee;
            }
            .available_time p, .available_time button, .available_time a{
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
    <p class="title">لیست کامل زمان‌هایی که شما برای تمرین رزرو کرده‌اید</p>
    <div id="times"></div>
    @include('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

function delete_reserve(id){
    if (confirm("آیا میخواهید این رزرو را حذف کنید؟")) {
        $.ajax({
        url: '/delete_salon_reserve',
        type: 'post',
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
            alert(data);
            show_salon_reserves();
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
    }
}

show_salon_reserves();
function show_salon_reserves(){
    $.ajax({
        url: '/get_salon_reserves_user_id',
        type: 'get',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
        document.getElementById("times").innerHTML = "";
        for (var i = 0; i < data.length ; i++) {
            const newLink = document.createElement("div");
            newLink.className = "available_time";
            newLink.innerHTML = "";
            newLink.innerHTML += '<p>هزینه: '+data[i].price+'</p>';
            newLink.innerHTML += '<p>تاریخ: '+data[i].day+'</p>';
            newLink.innerHTML += '<p>ساعت: '+data[i].start_time+' - '+data[i].end_time+'</p>';
            newLink.innerHTML += '<a href="<?php echo url('/salon?id='); ?>'+data[i].salon_id+'">مشاهده سالن</a>';
            newLink.innerHTML += '<button onclick="delete_reserve('+data[i].id+')">حذف</button>';
            document.getElementById("times").appendChild(newLink);
        }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}

</script>
</body>
</html>