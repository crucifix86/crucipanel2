<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('footer.management') }}
        </h2>
    </x-slot>

    <div class="container grid md:px-6 mx-auto">
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
                                <x-hrace009::simple-label for="content" :value="__('footer.content')" />
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
                                <x-hrace009::simple-label for="copyright" :value="__('footer.copyright')" />
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
                                <x-hrace009::button type="submit">
                                    {{ __('footer.save_content') }}
                                </x-hrace009::button>
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
                            <button 
                                @click="$dispatch('open-modal', 'add-social-link')"
                                class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 active:bg-primary-900 focus:outline-none focus:border-primary-900 focus:ring focus:ring-primary-300 disabled:opacity-25 transition"
                            >
                                {{ __('footer.add_social_link') }}
                            </button>
                        </div>
                        
                        @livewire('hrace009.admin.social-links-manager')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Social Link Modal -->
    <x-modal name="add-social-link" :show="false" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('footer.add_social_link') }}
            </h2>

            <form method="POST" action="{{ route('admin.footer.social.store') }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <x-hrace009::simple-label for="platform" :value="__('footer.platform')" />
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
                    <x-hrace009::simple-label for="url" :value="__('footer.url')" />
                    <x-hrace009::input-box
                        id="url"
                        name="url"
                        type="url"
                        placeholder="https://example.com/profile"
                        required
                    />
                </div>

                <div>
                    <x-hrace009::simple-label for="icon" :value="__('footer.icon_class')" />
                    <x-hrace009::input-box
                        id="icon"
                        name="icon"
                        type="text"
                        placeholder="fab fa-facebook"
                        required
                    />
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ __('footer.icon_help') }}
                    </p>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-hrace009::button type="submit">
                        {{ __('footer.add_link') }}
                    </x-hrace009::button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>