<?php
$date = Date::now();
$year = $date->year;
$month = $date->month;
$day = $date->day;

$day_of_week = $date->dayOfWeek;//yek0 shn6
$day_of_week++;//yek = 1 va shanbe = 0
if($day_of_week > 6)
    $day_of_week = 0;

$dates = array();
for($i=0;$i<$day_of_week;$i++){
    array_push($dates, "-");
}
array_push($dates, $year."/".$month."/".$day);

for($i=1;$i<=(35-$day_of_week);$i++){
    $date = $date->addDay(1);
    array_push($dates, $date->year."/".$date->month."/".$date->day);
}
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
        <meta charset="utf-8">
        <title>سالن</title>
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
                display: flex;
                width: 100%;
                margin: 10px 0;
                text-decoration: none;
                background: #eee;
            }
            .complex p , .complex button{
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
            .available_time p, .available_time button{
                display: inline-block;
                width: 100%;
                padding: 10px 0;
                font-size: large;
                text-align: center;
            }
            .month{
                display: block;
                width: 100%;
                margin: 10px auto;
                text-align: center;
                border-top: solid;
                border-bottom: solid;
            }
            .week{
                display: flex;
                width: 100%;
                margin: 0;
                border-bottom: solid;
            }
            .week:last-child{
                border: none;
            }
            .day{
                display: inline-block;
                width: 100%;
                padding: 10px 0;
                border-left: solid #9b9b9b;
                background: #eee;
            }
            .day:last-child{
                border: none;
            }
            .day0, .day1, .day2, .day3, .day4, .day5{
                background: #fff;
                cursor: pointer;
            }
            .day0:hover,
            .day1:hover,
            .day2:hover,
            .day3:hover,
            .day4:hover,
            .day5:hover{
                background: #4943ff;
                color: #fff;
            }
            .day6{
                background: #ff5353;
                color: #fff;
            }
        </style>
</head>
<body>

<?php
use Illuminate\Support\Facades\DB;
$id = request('id');
$salon = DB::table('salons')->where('id', $id)->get();
//$available_times = DB::table('available_times')->where('salon_id', $id)->get();
if(!isset($salon[0]))
{
    echo 'سالن یافت نشد';

    die();
}
    
?>

@include('header')
    <div class="complex">

        <p>نام: {{$salon[0]->name}}</p>
        <p>شماره: {{$salon[0]->phone}}</p>
        @if($salon[0]->creator_id == Auth::id())
        <button onclick="delete_salon({{$salon[0]->id}})">حذف</button>
        @endif
    </div>
    @if($salon[0]->creator_id==Auth::id())
        <a class="" href="{{ url('/salon_avaible_times/?id='.$id) }}">مدیریت زمان‌های سالن</a>
    @endif
    <div class="month">
        <div class="week">
            <div class="day">شنبه</div>
            <div class="day">یکشنبه</div>
            <div class="day">دوشنبه</div>
            <div class="day">سه‌شنبه</div>
            <div class="day">چهارشنبه</div>
            <div class="day">پنجشنبه</div>
            <div class="day">جمعه</div>
        </div>
        @for($i=0,$k=0;$i<=4;$i++)
        <div class="week">
            @for($j=0;$j<=6;$j++,$k++)
            @if($j != 6 && $dates[$k] != "-")
            <div class="day day{{$j}}" id="day{{$k}}" onclick="set_day({{$k}},'{{$dates[$k]}}',{{$j}})">{{$dates[$k]}}</div>
            @else
            <div class="day day{{$j}}" id="day{{$k}}">{{$dates[$k]}}</div>
            @endif
            @endfor
        </div>
        @endfor
    </div>
    <p class="title">لیست کامل زمان‌هایی که میتوانید برای تمرین رزرو کنید ریز نمایش داده شده‌اند</p>
    <div id="times"></div>
    @include('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

@if($salon[0]->creator_id == Auth::id())
function delete_salon(id){
    if (confirm("آیا میخواهید این سالن را حذف کنید؟")) {
    $.ajax({
        url: '/delete_salon',
        type: 'post',
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
            location.assign("{{url('/complex/?id=').$salon[0]->complex_id}}");
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
    }
}
@endif

function show_available_times(){
    $.ajax({
        url: '/get_available_times_day_of_week',
        type: 'get',
        data: {
            day: day,
            week_day: day_of_week,
            salon_id: {{$salon[0]->id}},
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
        document.getElementById("times").innerHTML = "";
        for (var i = 0; i < data.length ; i++) {
            const newLink = document.createElement("div");
            newLink.className = "available_time";
            newLink.innerHTML = "";
            newLink.innerHTML += '<p>هزینه: '+data[i].price+'</p>';
            newLink.innerHTML += '<p>زمان شروع: '+data[i].start_time+'</p>';
            newLink.innerHTML += '<p>زمان پایان: '+data[i].end_time+'</p>';
            newLink.innerHTML += '<button onclick="reserve_time('+data[i].id+')">رزرو</button>';
            document.getElementById("times").appendChild(newLink);
        }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}

var day = "";
var day_id = 0;
var day_of_week = 0;
function set_day(id,d,d1){
    day = d;
    document.getElementById("day"+day_id).style.boxShadow = "none";
    document.getElementById("day"+id).style.boxShadow = "inset 0px 0px 30px 10px #00b7ff";
    day_id = id;
    day_of_week = d1;
    show_available_times();
}

function reserve_time(id){
    $.ajax({
        url: '/add_salon_reserve',
        type: 'post',
        data: {
            day: day,
            id: id,
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
            show_available_times();
            alert(data);
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
}

check();
function check(){
    if(day != "")
        show_available_times();
    setTimeout(check, 5000);
}

</script>
</body>
</html>