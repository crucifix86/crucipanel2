@section('title', ' - Panel Update')
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">Panel Update</h1>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Current Version -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold mb-4 dark:text-gray-100">Current Version</h2>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">v{{ $currentVersion }}</p>
                        </div>
                    </div>

                    <!-- Latest Version -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold mb-4 dark:text-gray-100">Latest Version</h2>
                        @if($latestRelease)
                            @if(isset($latestRelease['no_releases']) && $latestRelease['no_releases'])
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-gray-600 dark:text-gray-400">No releases available yet.</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">
                                        When new releases are published on GitHub, they will appear here.
                                    </p>
                                </div>
                            @else
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">v{{ $latestRelease['version'] }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                        Released: {{ \Carbon\Carbon::parse($latestRelease['published_at'])->format('M d, Y') }}
                                    </p>
                                    <a href="{{ $latestRelease['html_url'] }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                        View on GitHub →
                                    </a>
                                </div>
                            @endif

                            @if($updateAvailable)
                                <div class="mt-4 p-4 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700 dark:text-yellow-200">
                                                A new version is available! Please review the changelog before updating.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 p-4 bg-green-100 dark:bg-green-900 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-700 dark:text-green-200">
                                                Your panel is up to date!
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="bg-red-100 dark:bg-red-900 rounded-lg p-4">
                                <p class="text-red-700 dark:text-red-200">Unable to check for updates. Please check your internet connection.</p>
                            </div>
                        @endif
                    </div>

                    @if($updateAvailable && $latestRelease && !isset($latestRelease['no_releases']))
                        <!-- Changelog -->
                        <div class="mb-8">
                            <h2 class="text-lg font-semibold mb-4 dark:text-gray-100">Changelog</h2>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                                <div class="prose dark:prose-invert max-w-none">
                                    {!! \Illuminate\Support\Str::markdown($latestRelease['notes'] ?? 'No changelog available.') !!}
                                </div>
                            </div>
                        </div>

                        <!-- Update Actions -->
                        <div class="border-t dark:border-gray-700 pt-6">
                            <h2 class="text-lg font-semibold mb-4 dark:text-gray-100">Update Actions</h2>
                            
                            <div class="space-y-4">
                                <!-- Backup -->
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <h3 class="font-medium dark:text-gray-100">1. Create Backup</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Recommended before updating</p>
                                    </div>
                                    <button id="backupBtn" onclick="createBackup()" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        Create Backup
                                    </button>
                                </div>

                                <!-- Update -->
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <h3 class="font-medium dark:text-gray-100">2. Install Update</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Update to version {{ $latestRelease['version'] }}</p>
                                    </div>
                                    <button id="updateBtn" onclick="installUpdate()" disabled
                                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Install Update
                                    </button>
                                </div>
                            </div>

                            <!-- Progress -->
                            <div id="progressContainer" class="mt-6 hidden">
                                <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                                    <div id="progressBar" class="bg-blue-600 h-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <p id="progressText" class="text-sm text-gray-600 dark:text-gray-400 mt-2"></p>
                            </div>

                            <!-- Messages -->
                            <div id="messageContainer" class="mt-4"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <script>
            let backupCreated = false;

            function showMessage(message, type = 'info') {
                const container = document.getElementById('messageContainer');
                const alertClass = {
                    'info': 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200',
                    'success': 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200',
                    'error': 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200',
                    'warning': 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200'
                };

                const alert = document.createElement('div');
                alert.className = `p-4 rounded-lg mb-2 ${alertClass[type]}`;
                alert.textContent = message;
                container.appendChild(alert);
            }

            function updateProgress(percent, text) {
                document.getElementById('progressContainer').classList.remove('hidden');
                document.getElementById('progressBar').style.width = percent + '%';
                document.getElementById('progressText').textContent = text;
            }

            async function createBackup() {
                const btn = document.getElementById('backupBtn');
                btn.disabled = true;
                btn.textContent = 'Creating...';

                try {
                    updateProgress(50, 'Creating backup...');
                    
                    const response = await fetch('{{ route('admin.system.update.backup') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        updateProgress(100, 'Backup created successfully!');
                        showMessage(`Backup created: ${data.backup_name} (${data.backup_size})`, 'success');
                        backupCreated = true;
                        document.getElementById('updateBtn').disabled = false;
                    } else {
                        showMessage(data.message || 'Failed to create backup', 'error');
                        updateProgress(0, '');
                    }
                } catch (error) {
                    showMessage('Error creating backup: ' + error.message, 'error');
                    updateProgress(0, '');
                } finally {
                    btn.disabled = false;
                    btn.textContent = 'Create Backup';
                }
            }

            async function installUpdate() {
                if (!backupCreated && !confirm('No backup has been created. Are you sure you want to continue?')) {
                    return;
                }

                if (!confirm('Are you sure you want to update the panel? This process may take several minutes.')) {
                    return;
                }

                const btn = document.getElementById('updateBtn');
                btn.disabled = true;
                btn.textContent = 'Installing...';
                document.getElementById('backupBtn').disabled = true;

                try {
                    updateProgress(20, 'Downloading update...');

                    const response = await fetch('{{ route('admin.system.update.install') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            download_url: '{{ $latestRelease['download_url'] ?? '' }}',
                            version: '{{ $latestRelease['version'] ?? '' }}'
                        })
                    });

                    updateProgress(60, 'Installing files...');

                    const data = await response.json();

                    if (data.success) {
                        updateProgress(100, 'Update downloaded successfully!');
                        showMessage(data.message, 'success');
                        
                        // Show instructions for completing update
                        const instructionsDiv = document.createElement('div');
                        instructionsDiv.className = 'mt-4 p-4 bg-blue-100 dark:bg-blue-900 rounded-lg';
                        instructionsDiv.innerHTML = `
                            <h3 class="font-semibold mb-2">Complete the update:</h3>
                            <p class="mb-2">Run this command in your terminal:</p>
                            <code class="block p-2 bg-gray-800 text-green-400 rounded">php artisan panel:update</code>
                            <p class="mt-2 text-sm">This command will apply the update and restart your panel.</p>
                        `;
                        document.getElementById('messageContainer').appendChild(instructionsDiv);
                        
                        // Disable buttons
                        btn.style.display = 'none';
                        document.getElementById('backupBtn').style.display = 'none';
                    } else {
                        showMessage(data.message || 'Update failed', 'error');
                        updateProgress(0, '');
                        btn.disabled = false;
                        btn.textContent = 'Install Update';
                        document.getElementById('backupBtn').disabled = false;
                    }
                } catch (error) {
                    showMessage('Error installing update: ' + error.message, 'error');
                    updateProgress(0, '');
                    btn.disabled = false;
                    btn.textContent = 'Install Update';
                    document.getElementById('backupBtn').disabled = false;
                }
            }
        </script>
    </x-slot>
</x-hrace009.layouts.admin>