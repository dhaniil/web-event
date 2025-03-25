<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Kolom Jurusan -->
        <div class="mb-3">
            <label for="jurusan" class="form-label">Jurusan</label>
            <select id="jurusan" name="jurusan" class="form-select">
                <option value="">Pilih Jurusan</option>
                <option value="SIJA A" {{ Auth::user()->jurusan == 'SIJA A' ? 'selected' : '' }}>SIJA A</option>
                <option value="SIJA B" {{ Auth::user()->jurusan == 'SIJA B' ? 'selected' : '' }}>SIJA B</option>
                <option value="TFLM A" {{ Auth::user()->jurusan == 'TFLM A' ? 'selected' : '' }}>TFLM A</option>
                <option value="TFLM B" {{ Auth::user()->jurusan == 'TFLM B' ? 'selected' : '' }}>TFLM B</option>
                <option value="KA A" {{ Auth::user()->jurusan == 'KA A' ? 'selected' : '' }}>KA A</option>
                <option value="KA B" {{ Auth::user()->jurusan == 'KA B' ? 'selected' : '' }}>KA B</option>
                <option value="GP A" {{ Auth::user()->jurusan == 'GP A' ? 'selected' : '' }}>GP A</option>
                <option value="GP B" {{ Auth::user()->jurusan == 'GP B' ? 'selected' : '' }}>GP B</option>
                <option value="DPIB A" {{ Auth::user()->jurusan == 'DPIB A' ? 'selected' : '' }}>DPIB A</option>
                <option value="DPIB B" {{ Auth::user()->jurusan == 'DPIB B' ? 'selected' : '' }}>DPIB B</option>
                <option value="TKR A" {{ Auth::user()->jurusan == 'TKR A' ? 'selected' : '' }}>TKR A</option>
                <option value="TKR B" {{ Auth::user()->jurusan == 'TKR B' ? 'selected' : '' }}>TKR B</option>
                <option value="TOI A" {{ Auth::user()->jurusan == 'TOI A' ? 'selected' : '' }}>TOI A</option>
                <option value="TOI B" {{ Auth::user()->jurusan == 'TOI B' ? 'selected' : '' }}>TOI B</option>
                <option value="TEK A" {{ Auth::user()->jurusan == 'TEK A' ? 'selected' : '' }}>TEK A</option>
                <option value="TEK B" {{ Auth::user()->jurusan == 'TEK B' ? 'selected' : '' }}>TEK B</option>
                <option value="TKI A" {{ Auth::user()->jurusan == 'TKI A' ? 'selected' : '' }}>TKI A</option>
                <option value="TKI B" {{ Auth::user()->jurusan == 'TKI B' ? 'selected' : '' }}>TKI B</option>
                <option value="TP" {{ Auth::user()->jurusan == 'TP' ? 'selected' : '' }}>TP</option>
                <option value="TBKR" {{ Auth::user()->jurusan == 'TBKR' ? 'selected' : '' }}>TBKR</option>
                <option value="TITL" {{ Auth::user()->jurusan == 'TITL' ? 'selected' : '' }}>TITL</option>
            </select>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
