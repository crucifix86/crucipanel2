<x-hrace009::layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('messages.view_message') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('messages.inbox') }}" class="btn btn-secondary">
                    <i class="fas fa-inbox mr-2"></i>{{ __('messages.inbox') }}
                </a>
                <a href="{{ route('messages.outbox') }}" class="btn btn-secondary">
                    <i class="fas fa-paper-plane mr-2"></i>{{ __('messages.outbox') }}
                </a>
            </div>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="mb-6">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4">
                                    <img class="h-12 w-12 rounded-full" 
                                         src="{{ $message->sender->profile_photo_url }}" 
                                         alt="{{ $message->sender->name }}">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ $message->subject ?: __('messages.no_subject') }}
                                        </h3>
                                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span>{{ __('messages.from') }}: <strong>{{ $message->sender->name }}</strong></span>
                                            <span>{{ __('messages.to') }}: <strong>{{ $message->recipient->name }}</strong></span>
                                            <span>{{ $message->created_at->format('M d, Y g:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    @if($message->sender_id !== Auth::id())
                                        <a href="{{ route('messages.reply', $message) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-reply mr-2"></i>{{ __('messages.reply') }}
                                        </a>
                                    @endif
                                    
                                    <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                            <i class="fas fa-trash mr-2"></i>{{ __('messages.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="prose dark:prose-invert max-w-none">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                {!! nl2br(e($message->message)) !!}
                            </div>
                        </div>
                        
                        @if($message->parent_id)
                            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                                    {{ __('messages.in_reply_to') }}
                                </h4>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <img class="h-8 w-8 rounded-full" 
                                             src="{{ $message->parent->sender->profile_photo_url }}" 
                                             alt="{{ $message->parent->sender->name }}">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $message->parent->sender->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $message->parent->created_at->format('M d, Y g:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ Str::limit($message->parent->message, 200) }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-hrace009::layouts.app>