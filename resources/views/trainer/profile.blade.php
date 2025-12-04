@extends('layouts.dashboard')

@section('title', 'Profile')

@section('sidebar')
@include('trainer.partials.sidebar')
@endsection

@section('content')
<div class="max-w-3xl">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Trainer Profile</h1>

    <!-- Update Profile -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Profile Information</h2>

        <form action="{{ route('trainer.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', auth()->user()->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email', auth()->user()->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                        required
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input 
                        type="text" 
                        name="phone" 
                        id="phone" 
                        value="{{ old('phone', auth()->user()->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
                    >
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                    <textarea 
                        name="bio" 
                        id="bio" 
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('bio') border-red-500 @enderror"
                        placeholder="Tell us about yourself..."
                    >{{ old('bio', auth()->user()->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">Specialization</label>
                    <input 
                        type="text" 
                        name="specialization" 
                        id="specialization" 
                        value="{{ old('specialization', auth()->user()->specialization) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('specialization') border-red-500 @enderror"
                        placeholder="e.g., Strength Training, HIIT, Yoga"
                    >
                    @error('specialization')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="certifications" class="block text-sm font-medium text-gray-700 mb-2">Certifications</label>
                    <input 
                        type="text" 
                        name="certifications" 
                        id="certifications" 
                        value="{{ old('certifications', auth()->user()->certifications) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('certifications') border-red-500 @enderror"
                        placeholder="e.g., NASM-CPT, ACE"
                    >
                    @error('certifications')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                    @if(auth()->user()->avatar)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover">
                    </div>
                    @endif
                    <input 
                        type="file" 
                        name="avatar" 
                        id="avatar" 
                        accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('avatar') border-red-500 @enderror"
                    >
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button 
                type="submit" 
                class="mt-6 px-6 py-2 bg-gradient-to-r from-blue-600 to-teal-500 text-white rounded-lg hover:from-blue-700 hover:to-teal-600 transition"
            >
                Update Profile
            </button>
        </form>
    </div>

    <!-- Change Password -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Change Password</h2>

        <form action="{{ route('trainer.profile.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Current Password <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        name="current_password" 
                        id="current_password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('current_password') border-red-500 @enderror"
                        required
                    >
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        New Password <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                        required
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm New Password <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required
                    >
                </div>
            </div>

            <button 
                type="submit" 
                class="mt-6 px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition"
            >
                Change Password
            </button>
        </form>
    </div>
</div>
@endsection
