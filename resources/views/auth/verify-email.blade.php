<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('از ثبت نام شما سپاسگزاریم! قبل از شروع، آیا می توانید آدرس ایمیل خود را با کلیک کردن روی پیوندی که به تازگی برای شما ایمیل کرده ایم تأیید کنید؟ اگر ایمیلی را دریافت نکردید، ما با کمال میل ایمیل دیگری را برای شما ارسال خواهیم کرد.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('یک پیوند تأیید جدید به آدرس ایمیلی که هنگام ثبت نام ارائه کرده اید ارسال شده است.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('ایمیل تایید را دوباره بفرست') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('خروج') }}
            </button>
        </form>
    </div>
</x-guest-layout>
