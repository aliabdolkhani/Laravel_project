<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
        <meta charset="utf-8">
        <title>salon available times</title>
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
                width: 100%;
                margin: 10px auto;
                font-size: large;
                text-align: center;
            }
            .new_complex input, .new_complex button, .new_complex select, .new_complex option{
                display: inline-block;
                width: 18%;
                margin: 10px auto;
                font-size: large;
                text-align: center;
                border: solid;
            }
            #times{
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
                width: 90%;
                margin: 10px 5%;
                text-decoration: none;
                background: #eee;
            }
            .available_time p, .available_time button{
                display: inline-block;
                width: 100%;
                padding: 10px 0;
                font-size: large;
                text-align: center;
            }
            .available_time button{
                background: red;
                color: #fff;
            }
            .available_time button:hover{
                background: blue;
            }
        </style>
</head>
<body>
    <?php
$id = request('id');
use App\Models\Salons;
$salon = Salons::find($id);
if($salon->creator_id!=Auth::id()){
    echo 'شما به این صفحه دسترسی ندارید';
    die();
}
?>

@include('header')
    <div class="complex">
        <p>نام: {{$salon->name}}</p>
        <p>شماره: {{$salon->phone}}</p>
    </div>
    <p class="title">شما میتوانید ساعات فعال را اینجا اضافه کنید</p>
    <form class="new_complex" id="new_time">
        <select id="week_day" name="week_day">
            <option value="" disabled selected>روز در هفته</option>
            <option value="0">شنبه</option>
            <option value="1">یکشنبه</option>
            <option value="2">دوشنبه</option>
            <option value="3">سه‌شنبه</option>
            <option value="4">چهارشنبه</option>
            <option value="5">پنجشنبه</option>
        </select>
        <select id="start_time" name="start_time">
            <option value="" disabled selected>زمان شروع</option>
            @for($i=0;$i<=23;$i++)
            <option value="{{$i}}:00" onclick="select_onclick('{{$i}}:00')">{{$i}}:00</option>
            <option value="{{$i}}:30" onclick="select_onclick('{{$i}}:30')">{{$i}}:30</option>
            @endfor
        </select>
        <select id="end_time" name="end_time">
            <option value="" disabled selected>زمان پایان</option>
        </select>
        <input id="price" name="price" placeholder="هزینه" type="number">
        <button type="submit">ثبت زمان</button>
    </form>
    <p class="title">لیست کامل زمان‌هایی که میتوانید برای تمرین رزرو کنید ریز نمایش داده شده‌اند</p>
    <div id="times"></div>
    @include('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

function week_day(d){
    switch (d) {
        case 0: return 'شنبه'; break;
        case 1: return 'یکشنبه'; break;
        case 2: return 'دوشنبه'; break;
        case 3: return 'سه‌شنبه'; break;
        case 4: return 'چهارشنبه'; break;
        case 5: return 'پنجشنبه'; break;
    }
    return 'جمعه';
}

$(function () {
    $('#new_time').submit(function (event) {
        event.preventDefault();
        var v1 = document.getElementById("week_day").value;
        var v2 = document.getElementById("start_time").value;
        var v3 = document.getElementById("end_time").value;
        var v4 = document.getElementById("price").value;
        if(v1 == "" || v2 == "" || v3 == "" || v4 == ""){
            alert("تمام ورودی ها را وارد کنید");
        } else {
            $.ajax({
                url: '/add_available_time',
                type: 'POST',
                data: {
                    week_day: v1,
                    start_time: v2,
                    end_time: v3,
                    price: v4,
                    salon_id: {{$id}},
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response);
                    show_available_times();
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
});

function show_available_times(){
    $.ajax({
        url: '/get_available_times',
        type: 'get',
        data: {
            salon_id: {{$salon->id}},
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
        document.getElementById("times").innerHTML = "";
        for (var i = 0; i < data.length ; i++) {
            const newLink = document.createElement("div");
            newLink.className = "available_time";
            newLink.innerHTML = "";
            newLink.innerHTML += '<p>روز در هفته: '+week_day(data[i].week_day)+'</p>';
            newLink.innerHTML += '<p>هزینه: '+data[i].price+'</p>';
            newLink.innerHTML += '<p>زمان شروع: '+data[i].start_time+'</p>';
            newLink.innerHTML += '<p>زمان پایان: '+data[i].end_time+'</p>';
            newLink.innerHTML += '<button onclick="delete_available_time('+data[i].id+')">حذف زمان</button>';
            document.getElementById("times").appendChild(newLink);
        }
        },
    });
}

function delete_available_time(id){
    $.ajax({
        url: '/delete_available_time',
        type: 'post',
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
            show_available_times();
        },
    });
}

check();
function check(){
    show_available_times();
    setTimeout(check, 10000);
}

function add_to_end_time(v){
    var o = document.createElement("option");
    o.text = v;
    o.value = v;
    document.getElementById("end_time").appendChild(o);
}
function select_onclick(v){
    document.getElementById("end_time").innerHTML = "";
    var i=0;
    for(; i<=23; i++){
        if(v == i+":00"){ j=0; add_to_end_time(i+":30"); break; }
        if(v == i+":30"){ j=1; break; }
    }
    i++;
    for(; i<=23; i++){
        add_to_end_time(i+":00");
        add_to_end_time(i+":30");
    }
}
</script>
</body>
</html>