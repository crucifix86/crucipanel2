@extends('hrace009.layouts.admin')

@section('content')
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('admin.edit_page') }}: {{ $page->title }}
            </h2>
            <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors duration-200">
                {{ __('admin.back_to_list') }}
            </a>
        </div>
    </x-slot>

    <div class="pb-12 mt-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-hrace009::admin.validation-error/>
                    
                    <form method="POST" action="{{ route('admin.pages.update', $page) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-hrace009::label for="title" value="{{ __('admin.page_title') }}" />
                            <x-hrace009::input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $page->title)" required autofocus />
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-hrace009::label for="nav_title" value="{{ __('admin.nav_title') }}" />
                            <x-hrace009::input id="nav_title" class="block mt-1 w-full" type="text" name="nav_title" :value="old('nav_title', $page->nav_title)" required />
                            @error('nav_title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('admin.nav_title_help') }}</p>
                        </div>

                        <div class="mb-4">
                            <x-hrace009::label for="slug" value="{{ __('admin.slug') }}" />
                            <x-hrace009::input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug', $page->slug)" />
                            @error('slug')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('admin.slug_help') }}</p>
                        </div>

                        <div class="mb-4">
                            <x-hrace009::label for="content" value="{{ __('admin.content') }}" />
                            <textarea id="content" name="content" rows="15" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('admin.content_help') }}</p>
                        </div>

                        <div class="mb-4">
                            <x-hrace009::label for="order" value="{{ __('admin.order') }}" />
                            <x-hrace009::input id="order" class="block mt-1 w-full" type="number" name="order" :value="old('order', $page->order)" />
                            @error('order')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('admin.order_help') }}</p>
                        </div>

                        <div class="mb-4">
                            <x-hrace009::label for="meta_description" value="{{ __('admin.meta_description') }}" />
                            <x-hrace009::input id="meta_description" class="block mt-1 w-full" type="text" name="meta_description" :value="old('meta_description', $page->meta_description)" />
                            @error('meta_description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-hrace009::label for="meta_keywords" value="{{ __('admin.meta_keywords') }}" />
                            <x-hrace009::input id="meta_keywords" class="block mt-1 w-full" type="text" name="meta_keywords" :value="old('meta_keywords', $page->meta_keywords)" />
                            @error('meta_keywords')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="active" value="1" {{ old('active', $page->active) ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                <span class="ml-2">{{ __('admin.active') }}</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="show_in_nav" value="1" {{ old('show_in_nav', $page->show_in_nav) ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                <span class="ml-2">{{ __('admin.show_in_nav') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-hrace009::button class="ml-4">
                                {{ __('admin.update') }}
                            </x-hrace009::button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection