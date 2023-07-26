<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
        <meta charset="utf-8">
        <title>SalonBegir</title>
        <style>
            .about_us{
                display: block;
                width: 90%;
                margin: 10px auto;
                font-size: large;
            }
        </style>
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
<p class="about_us">با سلام و احترام به همه علاقمندان به ورزش و فعالیت‌های بدنی. امروز می‌خواهیم به شما سایتی را معرفی کنیم که به شما امکان می‌دهد ورزشگاه‌هایی را که در نزدیکی شما قرار دارند، پیدا کنید و وقتی برای ورزش دارید، از آن‌ها استفاده کنید.</p>
<p class="about_us">این سایت با نام "سالن بگیر" (SalonBegir.com) نامیده می‌شود و یک پلتفرم تخصصی است که به شما کمک می‌کند ورزشگاه‌ها، باشگاه‌ها و سالن‌های ورزشی را در نزدیکی شما پیدا کنید. با ورود به این سایت، شما می‌توانید به راحتی و با استفاده از ابزارهای جستجوی ساده و کارآمد، به دنبال ورزشگاه‌هایی بگردید که به نیازهای شما پاسخ دهند. این سایت همچنین به شما امکان می‌دهد تا با استفاده از نظرات و امتیازات کاربران دیگر، بهترین ورزشگاه‌ها را در منطقه خود پیدا کنید.</p>
<p class="about_us">علاوه بر این، سالن بگیر به شما امکان می‌دهد تا ورزشگاه‌ها و سالن‌های ورزشی را بر اساس نوع ورزشی که می‌خواهید انجام دهید، دسته‌بندی کنید. بدین ترتیب، شما می‌توانید به راحتی و سریعی ورزشگاه‌هایی را که به نیازهای شما پاسخ می‌دهند، پیدا کنید.</p>
<p class="about_us">در کل، سالن بگیر یک پلتفرم کامل و جامع است که به شما کمک می‌کند تا به راحتی و با سرعت ورزشگاه‌ها و سالن‌های ورزشی در منطقه خود را پیدا کنید و برای فعالیت‌های بدنی خود به یک محیط مناسب دست یابید. با ورود به این سایت، شما می‌توانید به صورت رایگان و با استفاده از تمامی امکانات آن، به بهترین شکل ممکن از فعالیت‌های ورزشی خود لذت ببرید. به سالن بگیر سر بزنید و از تمامی امکاناتش لذت ببرید</p>
<p class="title">لیست کامل ورزشگاه‌های سایت را اینجا مشاهده کنید</p>
<div id="complexes"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

show_complexes();
function show_complexes(){
    $.get('/get_complexes', function(data) {
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
    @include('footer')
</body>
</html>