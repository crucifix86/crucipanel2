<x-hrace009::layouts.app>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('messages.compose') }}
        </h2>
    </x-slot>

    <x-slot name="content">
        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                    <form action="{{ route('messages.store') }}" method="POST" class="p-6">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="recipient" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.recipient') }}
                            </label>
                            
                            @if($recipient)
                                <input type="hidden" name="recipient_id" value="{{ $recipient->id }}">
                                <div class="flex items-center space-x-3 bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                    <img class="h-10 w-10 rounded-full" src="{{ $recipient->profile_photo_url }}" alt="{{ $recipient->name }}">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $recipient->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $recipient->email }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="relative">
                                    <input type="text" 
                                           id="recipient-search" 
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100"
                                           placeholder="{{ __('messages.search_users') }}">
                                    <div id="search-results" class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg hidden"></div>
                                    <input type="hidden" name="recipient_id" id="recipient_id" value="">
                                    <div id="selected-recipient" class="mt-2 hidden"></div>
                                </div>
                            @endif
                            
                            @error('recipient_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.subject') }} ({{ __('messages.optional') }})
                            </label>
                            <input type="text" 
                                   name="subject" 
                                   id="subject"
                                   value="{{ old('subject') }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100"
                                   maxlength="255">
                            @error('subject')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.message') }}
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
                            <a href="{{ route('messages.inbox') }}" class="btn btn-secondary">
                                {{ __('messages.cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane mr-2"></i>{{ __('messages.send') }}
                            </button>
                        </div>
                    </form>
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
        
        @unless($recipient)
        // User search functionality
        let searchTimeout;
        const searchInput = document.getElementById('recipient-search');
        const searchResults = document.getElementById('search-results');
        const recipientIdInput = document.getElementById('recipient_id');
        const selectedRecipientDiv = document.getElementById('selected-recipient');
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }
            
            searchTimeout = setTimeout(() => {
                fetch(`{{ route('messages.search-users') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(users => {
                        if (users.length === 0) {
                            searchResults.innerHTML = '<div class="p-3 text-gray-500 dark:text-gray-400">{{ __('messages.no_users_found') }}</div>';
                        } else {
                            searchResults.innerHTML = users.map(user => `
                                <div class="p-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer user-result" data-id="${user.id}" data-name="${user.name}" data-email="${user.email}">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">${user.name}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">${user.email}</div>
                                </div>
                            `).join('');
                        }
                        searchResults.classList.remove('hidden');
                        
                        // Add click handlers
                        document.querySelectorAll('.user-result').forEach(result => {
                            result.addEventListener('click', function() {
                                const userId = this.dataset.id;
                                const userName = this.dataset.name;
                                const userEmail = this.dataset.email;
                                
                                recipientIdInput.value = userId;
                                searchInput.value = '';
                                searchResults.classList.add('hidden');
                                
                                selectedRecipientDiv.innerHTML = `
                                    <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">${userName}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">${userEmail}</div>
                                        </div>
                                        <button type="button" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" onclick="clearRecipient()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                `;
                                selectedRecipientDiv.classList.remove('hidden');
                                searchInput.classList.add('hidden');
                            });
                        });
                    });
            }, 300);
        });
        
        // Click outside to close results
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
        
        function clearRecipient() {
            recipientIdInput.value = '';
            selectedRecipientDiv.classList.add('hidden');
            searchInput.classList.remove('hidden');
        }
        @endunless
    </script>
    @endpush
</x-hrace009::layouts.app>