@section('title', ' - Local Settings Management')
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">Local Settings Management</h1>
        </div>
    </x-slot>
    
    <x-slot name="content">
        <div class="max-w mx-auto mt-6 ml-6 mr-6">
            
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border-2 border-green-500 dark:border-green-400 text-green-900 dark:text-green-100 px-4 py-3 rounded-lg relative mb-4 font-semibold" role="alert">
                    <span class="block sm:inline">✓ {{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border-2 border-red-500 dark:border-red-400 text-red-900 dark:text-red-100 px-4 py-3 rounded-lg relative mb-4 font-semibold" role="alert">
                    <span class="block sm:inline">✗ {{ session('error') }}</span>
                </div>
            @endif
            
            <!-- Info Box -->
            <div class="bg-blue-50 dark:bg-blue-900/30 border-2 border-blue-500 dark:border-blue-400 text-blue-900 dark:text-blue-100 px-4 py-3 rounded-lg mb-6" role="alert">
                <div class="flex items-start">
                    <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="font-bold mb-1">About Local Settings</h3>
                        <p class="text-sm">Local settings persist through panel updates and config cache clearing. They're stored in a JSON file that won't be overwritten during updates.</p>
                        <p class="text-sm mt-2">Use this page to backup your settings before major updates or to restore them if something goes wrong.</p>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Settings Management</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Export Settings -->
                    <div class="text-center">
                        <h4 class="font-semibold mb-2">Export Settings</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Download all your current settings as a JSON file</p>
                        <a href="{{ route('admin.local-settings.export') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Export Settings
                        </a>
                    </div>
                    
                    <!-- Import Settings -->
                    <div class="text-center">
                        <h4 class="font-semibold mb-2">Import Settings</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Restore settings from a previously exported file</p>
                        <form method="POST" action="{{ route('admin.local-settings.import') }}" enctype="multipart/form-data" class="inline">
                            @csrf
                            <input type="file" name="settings_file" accept=".json" required class="hidden" id="settings-file">
                            <label for="settings-file" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 cursor-pointer">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Import Settings
                            </label>
                        </form>
                    </div>
                    
                    <!-- Clear Settings -->
                    <div class="text-center">
                        <h4 class="font-semibold mb-2">Clear All Settings</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Remove all local settings (use with caution!)</p>
                        <button onclick="confirmClear()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Clear Settings
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Current Settings -->
            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Current Local Settings</h3>
                
                @if(count($settings) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Setting Key</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Value</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($settings as $key => $value)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            <code>{{ $key }}</code>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            @if(is_bool($value))
                                                <span class="px-2 py-1 text-xs rounded {{ $value ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                    {{ $value ? 'true' : 'false' }}
                                                </span>
                                            @elseif(is_array($value))
                                                <code class="text-xs">{{ json_encode($value) }}</code>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ gettype($value) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        Total settings: {{ count($settings) }}
                    </p>
                @else
                    <p class="text-gray-600 dark:text-gray-400">No local settings found.</p>
                @endif
            </div>
        </div>
        
        <script>
            // Auto-submit when file is selected
            document.getElementById('settings-file').addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    e.target.form.submit();
                }
            });
            
            function confirmClear() {
                if (confirm('Are you sure you want to clear all local settings? This action cannot be undone!')) {
                    window.location.href = '{{ route('admin.local-settings.clear') }}?confirm=yes';
                }
            }
        </script>
    </x-slot>
</x-hrace009.layouts.admin>