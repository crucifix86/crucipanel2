@section('title', ' - Mass Message')
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">Mass Message</h1>
        </div>
    </x-slot>
    
    <x-slot name="content">
        <div class="container mx-auto px-4 py-6">

    @if (session('success'))
        <div class="bg-green-50 dark:bg-green-900/30 border-2 border-green-500 dark:border-green-400 text-green-900 dark:text-green-100 px-4 py-3 rounded-lg relative mb-4 font-semibold" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 dark:bg-red-900/30 border-2 border-red-500 dark:border-red-400 text-red-900 dark:text-red-100 px-4 py-3 rounded-lg relative mb-4 font-semibold" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <form action="{{ route('admin.mass-message.send') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="recipient_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Recipient Type
                </label>
                <select name="recipient_type" id="recipient_type" class="form-select block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    <option value="all">All Users</option>
                    <option value="active">Active Users (Last 30 days)</option>
                    <option value="role">By Role</option>
                </select>
            </div>

            <div class="mb-6" id="role-select" style="display: none;">
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Select Role
                </label>
                <select name="role" id="role" class="form-select block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    <option value="player">Players</option>
                    <option value="gamemaster">Gamemasters</option>
                    <option value="admin">Administrators</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Subject
                </label>
                <input type="text" name="subject" id="subject" required
                    class="form-input block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    placeholder="Enter message subject">
                @error('subject')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Message
                </label>
                <textarea name="message" id="message" rows="10" required
                    class="form-textarea block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    placeholder="Enter your message here..."></textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-yellow-50 dark:bg-yellow-900/30 border-2 border-yellow-400 dark:border-yellow-600 p-4 rounded-lg mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                            Warning
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                            <p>This will send a message to multiple users at once. Please review your message carefully before sending.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Send Message
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('recipient_type').addEventListener('change', function() {
        const roleSelect = document.getElementById('role-select');
        if (this.value === 'role') {
            roleSelect.style.display = 'block';
        } else {
            roleSelect.style.display = 'none';
        }
    });
</script>
    </x-slot>
</x-hrace009.layouts.admin>