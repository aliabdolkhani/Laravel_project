<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('حذف حساب') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('پس از حذف حساب شما، تمام منابع و داده های آن برای همیشه حذف می شوند. قبل از حذف حساب خود، لطفاً هر گونه داده یا اطلاعاتی را که می خواهید حفظ کنید دانلود کنید.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('حذف حساب') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('آیا مطمئن هستید که می خواهید اکانت خود را حذف کنید؟') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('پس از حذف حساب شما، تمام منابع و داده های آن برای همیشه حذف می شوند. لطفاً رمز عبور خود را وارد کنید تا تأیید کنید که می خواهید حساب خود را برای همیشه حذف کنید.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('رمزعبور') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('رمزعبور') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('لغو') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('حذف حساب') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
