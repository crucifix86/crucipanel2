@extends('components.hrace009.layouts.admin', ['content' => ''])

@section('title', ' - ' . __('header.title'))

@section('content')
    <x-slot name="header">
        <x-hrace009::admin.header>
            {{ __('header.title') }}
        </x-hrace009::admin.header>
    </x-slot>

    <x-slot name="content">
        <div class="mx-auto px-4 sm:px-6 md:px-8">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                        {{ __('header.settings') }}
                    </h3>
                    <div class="mt-2 max-w-xl text-sm text-gray-500 dark:text-gray-400">
                        <p>{{ __('header.settings_description') }}</p>
                    </div>

                    <form action="{{ route('admin.header.update') }}" method="POST" enctype="multipart/form-data" class="mt-5">
                        @csrf
                        
                        <div class="space-y-6">
                            {{-- Header Logo --}}
                            <div>
                                <label for="header_logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('header.header_logo') }}
                                </label>
                                <div class="mt-1">
                                    @if($headerSettings && $headerSettings->header_logo)
                                        <div class="mb-3">
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ __('header.current_logo') }}:</p>
                                            <img src="{{ asset($headerSettings->header_logo) }}" alt="Current Header Logo" class="max-h-20 bg-gray-100 dark:bg-gray-700 p-2 rounded">
                                        </div>
                                    @endif
                                    <input type="file" name="header_logo" id="header_logo" accept="image/*" 
                                           class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-full file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-indigo-50 file:text-indigo-700
                                                  hover:file:bg-indigo-100
                                                  dark:file:bg-gray-700 dark:file:text-gray-200">
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('header.logo_help') }}</p>
                                </div>
                                <div class="mt-3">
                                    <label for="header_logo_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('header.or_path') }}
                                    </label>
                                    <input type="text" name="header_logo_path" id="header_logo_path" 
                                           value="{{ $headerSettings->header_logo ?? 'img/logo/haven_perfect_world_logo.svg' }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                </div>
                            </div>

                            {{-- Badge Logo --}}
                            <div>
                                <label for="badge_logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('header.badge_logo') }}
                                </label>
                                <div class="mt-1">
                                    @if($headerSettings && $headerSettings->badge_logo)
                                        <div class="mb-3">
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">{{ __('header.current_badge') }}:</p>
                                            <img src="{{ asset($headerSettings->badge_logo) }}" alt="Current Badge Logo" class="max-h-12 bg-gray-100 dark:bg-gray-700 p-2 rounded">
                                        </div>
                                    @endif
                                    <input type="file" name="badge_logo" id="badge_logo" accept="image/*" 
                                           class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-full file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-indigo-50 file:text-indigo-700
                                                  hover:file:bg-indigo-100
                                                  dark:file:bg-gray-700 dark:file:text-gray-200">
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('header.badge_help') }}</p>
                                </div>
                                <div class="mt-3">
                                    <label for="badge_logo_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('header.or_path') }}
                                    </label>
                                    <input type="text" name="badge_logo_path" id="badge_logo_path" 
                                           value="{{ $headerSettings->badge_logo ?? 'img/logo/crucifix_logo.svg' }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('header.update_settings') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>
@endsection