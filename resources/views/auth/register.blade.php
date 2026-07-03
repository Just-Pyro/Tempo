@extends('layout.app')

@section('content')
    <x-wholepagewrapper>
        <x-sidebar page="register" />
        <div class="flex-1 flex justify-center items-center bg-gray-100">
            <x-formwrapper-auth>
                <form action="{{ route('user.store') }}" method="POST" class="flex flex-col gap-3">
                    @csrf
                    @method("POST")
                    <p class="greetings text-sm text-accent font-bold">GET STARTED</p>
                    <div>
                        <p class="form-title text-2xl font-medium">Create an account</p>
                        <p class="form-title text-sm">Set up your Tempo account in seconds.</p>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="fullname">Fullname</label>
                        <input type="text" id="fullname" name="fullname" class="px-4 py-2 rounded-xl border @error('fullname') border-red-300 @else border-gray-300 @enderror" placeholder="(e.g. Juan dela Cruz)" value="{{ old('fullname') }}">
                        @error('fullname')
                            <span class="text-red-800 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="px-4 py-2 rounded-xl border @error('email') border-red-300 @else border-gray-300 @enderror" placeholder="you@email.com" value="{{ old('email') }}">
                        @error('email')
                            <span class="text-red-800 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="px-4 py-2 rounded-xl border @error('password') border-red-300 @else border-gray-300 @enderror" placeholder="Create password">
                        @error('password')
                            <span class="text-red-800 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label for="confirm_password">Confirm password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="px-4 py-2 rounded-xl border @error('confirm_password') border-red-300 @else border-gray-300 @enderror" placeholder="Re-enter password">
                        @error('confirm_password')
                            <span class="text-red-800 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="rounded-xl border border-gray-300 flex justify-center items-center p-2 font-medium my-3">Log in</button>

                    <hr class="border border-gray-200 mb-3">
                    
                    <div class="flex justify-center">
                        <p class="text-sm">Already have an account? <a class="text-accent" href="{{ route('login') }}">Login</a></p>
                    </div>
                </form>
            </x-formwrapper-auth>
        </div>
    </x-wholepagewrapper>
@endsection