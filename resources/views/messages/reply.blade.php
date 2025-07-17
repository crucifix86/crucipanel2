<x-hrace009::layouts.app>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('messages.reply_to_message') }}
        </h2>
    </x-slot>

    <x-slot name="content">
        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <!-- Original Message -->
                        <div class="mb-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('messages.original_message') }}
                            </h4>
                            <div class="flex items-start space-x-3 mb-3">
                                <img class="h-10 w-10 rounded-full" 
                                     src="{{ $message->sender->profile_photo_url }}" 
                                     alt="{{ $message->sender->name }}">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $message->sender->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $message->created_at->format('M d, Y g:i A') }}
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-700 dark:text-gray-300">
                                            <strong>{{ __('messages.subject') }}:</strong> {{ $message->subject ?: __('messages.no_subject') }}
                                        </div>
                                    </div>
                                    <div class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                                        {!! nl2br(e($message->message)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Reply Form -->
                        <form action="{{ route('messages.reply.store', $message) }}" method="POST">
                            @csrf
                            
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.replying_to') }}
                                </label>
                                <div class="flex items-center space-x-3 bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                    <img class="h-10 w-10 rounded-full" src="{{ $recipient->profile_photo_url }}" alt="{{ $recipient->name }}">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $recipient->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $recipient->email }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.your_reply') }}
                                </label>
                                <textarea name="message" 
                                          id="message"
                                          rows="8"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100"
                                          maxlength="10000"
                                          required>{{ old('message') }}</textarea>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span id="char-count">0</span> / 10000 {{ __('messages.characters') }}
                                </p>
                                @error('message')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center justify-end space-x-4">
                                <a href="{{ route('messages.show', $message) }}" class="btn btn-secondary">
                                    {{ __('messages.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane mr-2"></i>{{ __('messages.send_reply') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    
    @push('scripts')
    <script>
        // Character counter
        const messageTextarea = document.getElementById('message');
        const charCount = document.getElementById('char-count');
        
        function updateCharCount() {
            charCount.textContent = messageTextarea.value.length;
        }
        
        messageTextarea.addEventListener('input', updateCharCount);
        updateCharCount();
    </script>
    @endpush
</x-hrace009::layouts.app>