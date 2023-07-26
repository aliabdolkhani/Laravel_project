<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
        <meta charset="utf-8">
        <title>complex</title>
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
                width: 30%;
                margin: 10px auto;
                font-size: large;
                text-align: center;
                border: solid;
            }
            #complexes{
                display: block;
                width: 100%;
            }
            .complex, .admin{
                display: flex;
                width: 100%;
                margin: 10px 0;
                text-decoration: none;
                background: #eee;
            }
            .complex p, .complex button{
                display: inline-block;
                width: 100%;
                padding: 10px 0;
                font-size: large;
                text-align: center;
            }
            .salon, .admin{
                display: inline-flex;
                width: 45%;
                margin: 10px 3.33% 10px 0;
                text-decoration: none;
                background: #eee;
            }
            .salon:hover{
                background: #fff;
            }
            .salon p, .admin p, .salon button, .admin button{
                display: inline-block;
                width: 100%;
                padding: 10px 0;
                font-size: large;
                text-align: center;
            }
        </style>
</head>
<body>
    <?php
    use Illuminate\Support\Facades\DB;
    use App\Models\Complexes;

    $id = request('id');
    $complex = Complexes::find($id);
    if(!isset($complex->id)){
        echo 'ورزشگاه پیدا نشد!';
        die();
    }
    if($complex->verify == false){
        echo 'ورزشگاه هنوز تایید نشده است!';
        die();
    }
    $role = DB::table('roles')->whereRaw('complex_id = ? and user_id = ?', [$id, Auth::id()])->get();
    $is_admin = false;
    if(isset($role[0]->id)){
        $is_admin = true;
    }
    ?>
        @include('header')
    <div class="complex">
        <p>نام: {{$complex->name}}</p>
        <p>شماره: {{$complex->phone}}</p>
        @if($complex->creator_id == Auth::id())
        <button onclick="delete_complex({{$complex->id}})">حذف</button>
        @endif
    </div>
    @if($complex->creator_id == Auth::id())
    <p class="title">شما میتوانید سالن‌های ورزشگاه را اینجا اضافه کنید</p>
    <form class="new_complex" id="new_complex_admin">
        <input id="u_id" name="u_id" placeholder="آیدی ادمین" type="number">
        <button type="submit">ثبت ادمین</button>
    </form>
    <p class="title">لیست کامل ادمین‌های ورزشگاه</p>
    <div id="complex_admins"></div>
    @endif
    @if($complex->creator_id == Auth::id() || $is_admin == true)
    <p class="title">شما میتوانید سالن خود را اضافه کنید</p>
    <form class="new_complex" id="new_salon">
        <input id="name" name="name" placeholder="نام" type="text">
        <input id="phone" name="phone" placeholder="شماره" type="number">
        <button type="submit">ثبت سالن</button>
    </form>
    @endif
    <p class="title">لیست کامل سالن‌های ورزشگاه</p>
    <div id="salons"></div>
    @include('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

@if($complex->creator_id == Auth::id() || $is_admin == true)
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
            location.assign("{{url('/')}}");
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
    }
}

$(function () {
    $('#new_salon').submit(function (event) {
        event.preventDefault();
        var v1 = document.getElementById("name").value;
        var v2 = document.getElementById("phone").value;
        if(v1 == "" || v2 == ""){
            alert("تمام ورودی ها را وارد کنید");
        } else {
            $.ajax({
                url: '/add_salon',
                type: 'POST',
                data: {
                    name: v1,
                    phone: v2,
                    creator_id: {{Auth::id()}},
                    complex_id: {{$complex->id}},
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response);
                    show_salons();
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
});
@endif

@if($complex->creator_id == Auth::id())
$(function () {
    $('#new_complex_admin').submit(function (event) {
        event.preventDefault();
        var v1 = document.getElementById("u_id").value;
        if(v1 == ""){
            alert("تمام ورودی ها را وارد کنید");
        } else {
            $.ajax({
                url: '/add_role',
                type: 'POST',
                data: {
                    user_id: v1,
                    complex_id: {{$complex->id}},
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response);
                    show_complex_admins();
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
});

show_complex_admins();
function show_complex_admins(){
    $.ajax({
        url: '/get_roles',
        type: 'get',
        data: {
            complex_id: {{$complex->id}},
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
        document.getElementById("complex_admins").innerHTML = "";
        for (var i = data.length-1; i >= 0 ; i--) {
            const newLink = document.createElement("div");
            newLink.className = "admin";
            newLink.innerHTML = "";
            newLink.innerHTML += '<p>آیدی: '+data[i].id+'</p>';
            newLink.innerHTML += '<p>نام: '+data[i].name+'</p>';
            newLink.innerHTML += '<button onclick="delete_admin('+data[i].rid+')">حذف</button>';
            document.getElementById("complex_admins").appendChild(newLink);
        }
        },
    });
}

function delete_admin(id){
    $.ajax({
        url: '/delete_role',
        type: 'post',
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
            show_complex_admins();
        },
    });
}

@endif

function show_salons(){
    $.ajax({
        url: '/get_salons',
        type: 'get',
        data: {
            complex_id: {{$complex->id}},
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
        document.getElementById("salons").innerHTML = "";
        for (var i = data.length-1; i >= 0 ; i--) {
            const newLink = document.createElement("a");
            newLink.className = "salon";
            newLink.href = '<?php echo url('/salon?id='); ?>'+data[i].id;
            newLink.innerHTML = "";
            newLink.innerHTML += '<p>نام: '+data[i].name+'</p>';
            newLink.innerHTML += '<p>شماره: '+data[i].phone+'</p>';
            document.getElementById("salons").appendChild(newLink);
        }
        },
    });
}

check();
function check(){
    show_salons();
    setTimeout(check, 10000);
}

</script>

</body>
</html>