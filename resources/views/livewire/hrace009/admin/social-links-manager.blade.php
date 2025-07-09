<div>
    @if (session()->has('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-2">
        @forelse($socialLinks as $link)
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                @if($editingId === $link->id)
                    <div class="flex-1 grid grid-cols-3 gap-2">
                        <input
                            type="text"
                            wire:model="editingPlatform"
                            class="px-3 py-2 border rounded-md dark:bg-darker dark:border-gray-700 focus:outline-none focus:ring focus:ring-primary-100"
                            placeholder="{{ __('footer.platform') }}"
                        />
                        <input
                            type="url"
                            wire:model="editingUrl"
                            class="px-3 py-2 border rounded-md dark:bg-darker dark:border-gray-700 focus:outline-none focus:ring focus:ring-primary-100"
                            placeholder="{{ __('footer.url') }}"
                        />
                        <div class="flex space-x-2">
                            <button
                                wire:click="update"
                                class="px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                            >
                                {{ __('Save') }}
                            </button>
                            <button
                                wire:click="cancelEdit"
                                class="px-3 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700"
                            >
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <i class="{{ $link->icon }} text-xl w-6"></i>
                        <span class="font-medium">{{ $link->platform }}</span>
                        <a href="{{ $link->url }}" target="_blank" class="text-primary-600 hover:underline">
                            {{ $link->url }}
                        </a>
                        <span class="px-2 py-1 text-xs rounded-full {{ $link->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $link->active ? __('Active') : __('Inactive') }}
                        </span>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <button
                            wire:click="moveUp({{ $link->id }})"
                            @if($loop->first) disabled @endif
                            class="p-1 text-gray-600 hover:text-gray-900 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        </button>
                        
                        <button
                            wire:click="moveDown({{ $link->id }})"
                            @if($loop->last) disabled @endif
                            class="p-1 text-gray-600 hover:text-gray-900 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <button
                            wire:click="toggleActive({{ $link->id }})"
                            class="p-1 text-gray-600 hover:text-gray-900"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($link->active)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                @endif
                            </svg>
                        </button>
                        
                        <button
                            wire:click="startEdit({{ $link->id }})"
                            class="p-1 text-blue-600 hover:text-blue-900"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        
                        <button
                            wire:click="delete({{ $link->id }})"
                            wire:confirm="{{ __('footer.confirm_delete') }}"
                            class="p-1 text-red-600 hover:text-red-900"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-500 text-center py-8">{{ __('footer.no_social_links') }}</p>
        @endforelse
    </div>
</div>