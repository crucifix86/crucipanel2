@section('title', ' - ' . __('footer.management'))
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('footer.management') }}</h1>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-col space-y-6">
            <!-- Footer Content Section -->
            <div class="w-full md:pb-2 md:pt-12">
                <x-slot name="title">
                    {{ __('footer.content_settings') }}
                </x-slot>
                <div class="max-w-7xl mx-auto">
                    <div class="border bg-white dark:bg-darker shadow-xs rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('footer.content_settings') }}</h3>
                        
                        <form action="{{ route('admin.footer.updateContent') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <x-hrace009::label for="content" :value="__('footer.content')" />
                                <textarea
                                    id="content"
                                    name="content"
                                    rows="6"
                                    class="w-full px-4 py-2 mt-1 border rounded-md dark:bg-darker dark:border-gray-700 focus:outline-none focus:ring focus:ring-primary-100 dark:focus:ring-primary-darker"
                                    placeholder="{{ __('footer.content_placeholder') }}"
                                >{{ old('content', $footerSettings?->content) }}</textarea>
                                @error('content')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <x-hrace009::label for="copyright" :value="__('footer.copyright')" />
                                <x-hrace009::input-box
                                    id="copyright"
                                    name="copyright"
                                    type="text"
                                    :value="old('copyright', $footerSettings?->copyright)"
                                    placeholder="{{ __('footer.copyright_placeholder') }}"
                                />
                                @error('copyright')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('footer.save_content') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Social Links Section -->
            <div class="w-full md:pb-12">
                <x-slot name="title">
                    {{ __('footer.social_links') }}
                </x-slot>
                <div class="max-w-7xl mx-auto">
                    <div class="border bg-white dark:bg-darker shadow-xs rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('footer.social_links') }}</h3>
                            <a 
                                href="#add-social-link"
                                onclick="document.getElementById('add-social-modal').style.display='block'"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('footer.add_social_link') }}
                            </a>
                        </div>
                        
                        @livewire('hrace009.admin.social-links-manager')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Social Link Modal -->
    <div id="add-social-modal" style="display:none;" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="document.getElementById('add-social-modal').style.display='none'"></div>
            
            <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-md w-full p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('footer.add_social_link') }}
                </h2>

                <form method="POST" action="{{ route('admin.footer.social.store') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <x-hrace009::label for="platform" :value="__('footer.platform')" />
                        <select
                            id="platform"
                            name="platform"
                            class="w-full px-4 py-2 mt-1 border rounded-md dark:bg-darker dark:border-gray-700 focus:outline-none focus:ring focus:ring-primary-100 dark:focus:ring-primary-darker"
                            required
                        >
                            <option value="">{{ __('footer.select_platform') }}</option>
                            <option value="facebook">Facebook</option>
                            <option value="twitter">Twitter</option>
                            <option value="instagram">Instagram</option>
                            <option value="youtube">YouTube</option>
                            <option value="linkedin">LinkedIn</option>
                            <option value="discord">Discord</option>
                            <option value="twitch">Twitch</option>
                            <option value="github">GitHub</option>
                            <option value="tiktok">TikTok</option>
                            <option value="reddit">Reddit</option>
                        </select>
                    </div>

                    <div>
                        <x-hrace009::label for="url" :value="__('footer.url')" />
                        <x-hrace009::input-box
                            id="url"
                            name="url"
                            type="url"
                            placeholder="https://example.com/profile"
                            required
                        />
                    </div>

                    <div>
                        <x-hrace009::label for="icon" :value="__('footer.icon_class')" />
                        <x-hrace009::input-box
                            id="icon"
                            name="icon"
                            type="text"
                            placeholder="fa-facebook"
                            required
                        />
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ __('footer.icon_help') }}
                        </p>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('add-social-modal').style.display='none'" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            {{ __('Cancel') }}
                        </button>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('footer.add_link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>
</x-hrace009.layouts.admin>