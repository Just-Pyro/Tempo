@extends('layout.app')

@section('content')
    <x-wholepagewrapper>
        <x-sidebar page="login" />
        <div class="flex-1 flex justify-center items-center bg-gray-100">

            <x-formwrapper-auth>
                <form action="{{ route('user.login') }}" method="POST" class="flex flex-col gap-3">
                    @csrf
                    @method('POST')
                    <p class="greetings text-sm text-accent font-bold">WELCOME BACK</p>
                    <div>
                        <p class="form-title text-2xl font-medium">Log in</p>
                        <p class="form-title text-sm">Enter your credentials to continue.</p>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="px-4 py-2 rounded-xl border @error('email') border-red-300 @else border-gray-300 @enderror" placeholder="you@email.com">
                        @error('email')
                            <span class="text-red-800 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="px-4 py-2 rounded-xl border @error('password') border-red-300 @else border-gray-300 @enderror" placeholder="password here">
                        @error('password')
                            <span class="text-red-800 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="rounded-xl border border-gray-300 flex justify-center items-center p-2 font-medium my-3">Log in</button>

                    <hr class="border border-gray-200 mb-3">
                    
                    <div class="flex justify-center">
                        <p class="text-sm">Don't have an account? <a class="text-accent" href="{{ route('register') }}">Register</a></p>
                    </div>
                </form>
            </x-formwrapper-auth>
        </div>
    </x-wholepagewrapper>
@endsection