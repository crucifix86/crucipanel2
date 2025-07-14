@section('title', ' - ' . __('header.title'))
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('header.title') }}</h1>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="mx-auto px-4 sm:px-6 md:px-8">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('admin.header.update') }}" method="POST">
                    @csrf
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('header.content_editor') }}
                        </h3>
                        
                        {{-- Content Editor --}}
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('header.content') }}
                            </label>
                            <textarea name="content" id="content" rows="8" 
                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md">{{ config('header.content') }}</textarea>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('header.content_help', 'Edit the HTML content for your header') }}
                            </p>
                        </div>
                        
                        {{-- Alignment Options --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('header.alignment') }}
                            </label>
                            <div class="flex space-x-4">
                                @php
                                    $currentAlignment = config('header.alignment', 'center');
                                @endphp
                                
                                <button type="button" 
                                        onclick="document.getElementById('alignment').value='left'; updateAlignmentButtons('left')"
                                        class="alignment-btn px-4 py-2 border rounded-md text-sm font-medium transition-colors duration-200 
                                               {{ $currentAlignment === 'left' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600' }}"
                                        data-alignment="left">
                                    <i class="fas fa-align-left"></i> {{ __('header.align_left', 'Left') }}
                                </button>
                                
                                <button type="button" 
                                        onclick="document.getElementById('alignment').value='center'; updateAlignmentButtons('center')"
                                        class="alignment-btn px-4 py-2 border rounded-md text-sm font-medium transition-colors duration-200 
                                               {{ $currentAlignment === 'center' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600' }}"
                                        data-alignment="center">
                                    <i class="fas fa-align-center"></i> {{ __('header.align_center', 'Center') }}
                                </button>
                                
                                <button type="button" 
                                        onclick="document.getElementById('alignment').value='right'; updateAlignmentButtons('right')"
                                        class="alignment-btn px-4 py-2 border rounded-md text-sm font-medium transition-colors duration-200 
                                               {{ $currentAlignment === 'right' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600' }}"
                                        data-alignment="right">
                                    <i class="fas fa-align-right"></i> {{ __('header.align_right', 'Right') }}
                                </button>
                            </div>
                            <input type="hidden" name="alignment" id="alignment" value="{{ $currentAlignment }}">
                        </div>
                        
                        {{-- Submit Button --}}
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('header.save_content', 'Save Header') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </x-slot>

    @push('scripts')
    <script>
        function updateAlignmentButtons(alignment) {
            document.querySelectorAll('.alignment-btn').forEach(btn => {
                if (btn.dataset.alignment === alignment) {
                    btn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                    btn.classList.remove('bg-white', 'text-gray-700', 'border-gray-300', 'hover:bg-gray-50', 'dark:bg-gray-700', 'dark:text-gray-300', 'dark:border-gray-600');
                } else {
                    btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                    btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300', 'hover:bg-gray-50', 'dark:bg-gray-700', 'dark:text-gray-300', 'dark:border-gray-600');
                }
            });
        }
    </script>
    @endpush
</x-hrace009.layouts.admin>