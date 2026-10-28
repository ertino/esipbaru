<x-guest-layout>

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left Logo -->
                <div class="flex-shrink-0 flex items-center space-x-2">
                    <a href="/" class="flex items-center space-x-2">
                        <img class="h-10" src="{{ asset('images/ptsplogo.png') }}" alt="Logo 1">
                        <img class="h-10" src="{{ asset('images/logo-clp.png') }}" alt="Logo 2">
                    </a>
                </div>
                <!-- Navigation Menu -->
                <div class="hidden sm:flex sm:space-x-8">
                    <x-nav-link href="#" :active="request()->is('/')">
                        Beranda
                    </x-nav-link>
                    <x-nav-link href="#" :active="request()->is('about')">
                        Tentang Kami
                    </x-nav-link>
                    <x-nav-link href="#" id="pengumuman-link">
                        Pengumuman
                    </x-nav-link>
                </div>
            </div>
        </div>
    </nav>
    <x-auth-card>
        <!-- Add a top-right corner link for "PENGUMUMAN" -->

        <x-slot name="logo">
            <a href="/">
                <img src="{{asset('images/NAKES.png')}}" width="300px" alt="">
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username -->
            <div>
                <x-label for="username" :value="__('Username')" />

                <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- CAPTCHA -->
            <div class="mt-4">
                <x-label for="captcha" :value="__('Captcha')" />
                <div class="flex items-center">
                    <input id="captcha" type="text" class="block w-full mt-1 border rounded-md p-2" name="captcha" required>
                    <img src="{{ captcha_src() }}" class="ml-2" onclick="this.src='{{ captcha_src() }}?'+Math.random()" alt="captcha">
                </div>
                @if ($errors->has('captcha'))
                    <span class="text-red-500 text-sm">{{ $errors->first('captcha') }}</span>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div class="block mt-4">
                <a href="{{route('lupa.password')}}">Lupa Password</a>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
                <a class="ml-3" href="{{route('daftar.nakes')}}">
                    DAFTAR
                </a>
            </div>
        </form>
    </x-auth-card>

    <!-- Modal Structure -->
    <div id="pengumuman-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900 bg-opacity-75">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl">
            <h2 class="text-xl font-semibold mb-4">Pengumuman</h2>
            <p class="text-gray-600">
                Mohon Untuk Perhatikan Pengumuman Berikut Sebelum Anda Login Ke Aplikasi URAT NADI.
            </p>
            <div class="overflow-y-auto" style="max-height: 400px;">
                <img src="{{asset('images/anounce.jpeg')}}" class="w-full" alt="Pengumuman">
            </div>
            <div class="flex justify-end mt-6">
                <button id="close-modal" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>

</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const pengumumanLink = document.getElementById('pengumuman-link');
        const modal = document.getElementById('pengumuman-modal');
        const closeModal = document.getElementById('close-modal');

        // Automatically show the modal on page load
        modal.classList.remove('hidden');

        // Hide the modal when the "Close" button is clicked
        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Optional: Close the modal when clicking outside the modal content
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });

        pengumumanLink.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent the default link behavior
            modal.classList.remove('hidden'); // Show the modal
        });
    });
</script>

