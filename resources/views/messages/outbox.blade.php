<x-hrace009::layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('messages.outbox') }}
            </h2>
            <a href="{{ route('messages.compose') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>{{ __('messages.compose') }}
            </a>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="py-4">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        @if($messages->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('messages.to') }}
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('messages.subject') }}
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('messages.date') }}
                                            </th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('messages.actions') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($messages as $message)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full" src="{{ $message->recipient->profile_photo_url }}" alt="{{ $message->recipient->name }}">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                                {{ $message->recipient->name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $message->subject ?: __('messages.no_subject') }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ Str::limit($message->message, 50) }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $message->created_at->diffForHumans() }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('messages.show', $message) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                                        {{ __('messages.view') }}
                                                    </a>
                                                    <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                                            {{ __('messages.delete') }}
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-4">
                                {{ $messages->links() }}
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-paper-plane text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                <p class="text-gray-500 dark:text-gray-400">{{ __('messages.no_sent_messages') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-hrace009::layouts.app>