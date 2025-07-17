<div class="bg-white dark:bg-darker rounded-lg shadow-md p-6">
    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Choose Your Theme</h2>
    
    <div class="grid grid-cols-1 gap-4">
        @foreach($themes as $key => $theme)
        <div 
            wire:click="selectTheme('{{ $key }}')"
            class="cursor-pointer rounded-lg overflow-hidden border-2 transition-all duration-200 transform hover:scale-105 {{ $currentTheme === $key ? 'border-primary-500 shadow-lg' : 'border-gray-200 dark:border-gray-700' }}"
        >
            <div class="flex items-center p-4">
                <!-- Theme Preview Colors -->
                <div class="flex space-x-2 mr-4">
                    @if(isset($theme['colors']))
                        @foreach(array_slice($theme['colors'], 0, 3) as $color)
                        <div 
                            class="w-8 h-8 rounded-full border border-gray-300 dark:border-gray-600"
                            style="background-color: {{ $color }}"
                        ></div>
                        @endforeach
                    @else
                        <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                        <div class="w-8 h-8 rounded-full bg-gray-400 dark:bg-gray-500"></div>
                        <div class="w-8 h-8 rounded-full bg-gray-500 dark:bg-gray-400"></div>
                    @endif
                </div>
                
                <!-- Theme Info -->
                <div class="flex-1">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">
                        {{ $theme['name'] }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $theme['description'] }}
                    </p>
                </div>
                
                <!-- Selected Indicator -->
                @if($currentTheme === $key)
                <div class="bg-green-500 text-white rounded-full p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>