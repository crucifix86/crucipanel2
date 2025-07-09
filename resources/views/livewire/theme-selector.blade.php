<div>
    <!-- Theme Selector Button -->
    <button 
        wire:click="$set('showModal', true)"
        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-150"
        title="Change Theme"
    >
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
        </svg>
        <span>{{ $themes[$currentTheme]['name'] ?? 'Theme' }}</span>
    </button>

    <!-- Theme Selector Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" wire:click="$set('showModal', false)">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

            <div 
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full"
                wire:click.stop
            >
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Choose Your Theme
                        </h3>
                        <button 
                            wire:click="$set('showModal', false)"
                            class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($themes as $key => $theme)
                        <div 
                            wire:click="selectTheme('{{ $key }}')"
                            class="cursor-pointer rounded-lg overflow-hidden border-2 transition-all duration-200 transform hover:scale-105 {{ $currentTheme === $key ? 'border-primary-500 shadow-lg' : 'border-gray-200 dark:border-gray-700' }}"
                        >
                            <!-- Theme Preview -->
                            <div class="h-40 bg-gradient-to-br 
                                @if($key === 'default') from-gray-100 to-gray-300 dark:from-gray-700 dark:to-gray-900
                                @elseif($key === 'gamer-dark') from-green-900 via-black to-purple-900
                                @elseif($key === 'cyberpunk') from-yellow-600 via-pink-600 to-black
                                @endif
                                relative overflow-hidden"
                            >
                                @if($key === 'gamer-dark')
                                    <!-- Gamer theme preview elements -->
                                    <div class="absolute inset-0 opacity-20">
                                        <div class="h-full w-full bg-gradient-to-r from-transparent via-green-400 to-transparent animate-pulse"></div>
                                    </div>
                                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-green-400 via-purple-500 to-pink-500"></div>
                                @elseif($key === 'cyberpunk')
                                    <!-- Cyberpunk theme preview elements -->
                                    <div class="absolute top-4 left-4 text-yellow-300 font-bold text-xs">CYBER_</div>
                                    <div class="absolute bottom-4 right-4 text-pink-500 font-bold text-xs">_PUNK</div>
                                    <div class="absolute inset-0 bg-black opacity-20"></div>
                                @endif
                                
                                @if($currentTheme === $key)
                                <div class="absolute top-2 right-2 bg-green-500 text-white rounded-full p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Theme Info -->
                            <div class="p-4 bg-white dark:bg-gray-800">
                                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-1">
                                    {{ $theme['name'] }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $theme['description'] }}
                                </p>
                                
                                @if(isset($theme['colors']))
                                <div class="flex space-x-1 mt-3">
                                    @foreach(array_slice($theme['colors'], 0, 4) as $color)
                                    <div 
                                        class="w-6 h-6 rounded-full border border-gray-200 dark:border-gray-700"
                                        style="background-color: {{ $color }}"
                                    ></div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>