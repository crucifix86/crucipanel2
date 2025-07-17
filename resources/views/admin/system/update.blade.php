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
                                <div class="mt-4 p-4 bg-yellow-100 dark:bg-yellow-900/50 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-500 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-800 dark:text-yellow-100">
                                                A new version is available! Please review the changelog before updating.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 p-4 bg-green-100 dark:bg-green-900/50 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-500 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-green-800 dark:text-green-100">
                                                Your panel is up to date!
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="bg-red-100 dark:bg-red-900/50 rounded-lg p-4">
                                <p class="text-red-800 dark:text-red-100">Unable to check for updates. Please check your internet connection.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Backup Section (Always Visible) -->
                    <div class="border-t dark:border-gray-700 pt-6 mb-8">
                        <h2 class="text-lg font-semibold mb-4 dark:text-gray-100">Backup Management</h2>
                        
                        <div class="space-y-4">
                            <!-- Create Backup -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <h3 class="font-medium dark:text-gray-100">Create Panel Backup</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Create a backup of your panel before making changes</p>
                                </div>
                                <button id="backupBtn" onclick="createBackup()" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Create Backup
                                </button>
                            </div>
                            
                            <!-- Restore Info -->
                            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                            How to Restore
                                        </h3>
                                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                            <p>To restore a backup, run this command from your panel directory:</p>
                                            <code class="block mt-2 p-2 bg-gray-800 text-green-400 rounded font-mono text-xs">./restore-backup.sh</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Backup Progress -->
                        <div id="backupProgressContainer" class="mt-4 hidden">
                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                                <div id="backupProgressBar" class="bg-blue-600 h-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <p id="backupProgressText" class="text-sm text-gray-600 dark:text-gray-400 mt-2"></p>
                        </div>
                        
                        <!-- Backup Messages -->
                        <div id="backupMessageContainer" class="mt-4"></div>
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
                            <h2 class="text-lg font-semibold mb-4 dark:text-gray-100">Update to {{ $latestRelease['version'] }}</h2>
                            
                            <div class="space-y-4">
                                <!-- Update -->
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <h3 class="font-medium dark:text-gray-100">Install Update</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Update to version {{ $latestRelease['version'] }}</p>
                                    </div>
                                    <button id="updateBtn" onclick="installUpdate()" 
                                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
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

            function showMessage(message, type = 'info', containerId = 'messageContainer') {
                const container = document.getElementById(containerId);
                if (!container) return;
                
                const alertClass = {
                    'info': 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-100',
                    'success': 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-100',
                    'error': 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-100',
                    'warning': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-100'
                };

                const alert = document.createElement('div');
                alert.className = `p-4 rounded-lg mb-2 ${alertClass[type]}`;
                alert.textContent = message;
                container.appendChild(alert);
            }

            function updateProgress(percent, text, isBackup = false) {
                let progressContainer, progressBar, progressText;
                
                if (isBackup) {
                    progressContainer = document.getElementById('backupProgressContainer');
                    progressBar = document.getElementById('backupProgressBar');
                    progressText = document.getElementById('backupProgressText');
                } else {
                    progressContainer = document.getElementById('progressContainer');
                    progressBar = document.getElementById('progressBar');
                    progressText = document.getElementById('progressText');
                }
                
                if (progressContainer && progressBar && progressText) {
                    progressContainer.classList.remove('hidden');
                    progressBar.style.width = percent + '%';
                    progressText.textContent = text;
                }
            }

            async function createBackup() {
                const btn = document.getElementById('backupBtn');
                btn.disabled = true;
                btn.textContent = 'Creating...';

                try {
                    updateProgress(50, 'Creating backup...', true);
                    
                    const response = await fetch('{{ route('admin.system.update.backup') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        updateProgress(100, 'Backup created successfully!', true);
                        showMessage(`Backup created: ${data.backup_name} (${data.backup_size})`, 'success', 'backupMessageContainer');
                        backupCreated = true;
                        // Only enable update button if it exists
                        const updateBtn = document.getElementById('updateBtn');
                        if (updateBtn) {
                            updateBtn.disabled = false;
                        }
                    } else {
                        showMessage(data.message || 'Failed to create backup', 'error', 'backupMessageContainer');
                        updateProgress(0, '', true);
                    }
                } catch (error) {
                    showMessage('Error creating backup: ' + error.message, 'error', 'backupMessageContainer');
                    updateProgress(0, '', true);
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
                        instructionsDiv.className = 'mt-4 p-4 bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-100 rounded-lg';
                        instructionsDiv.innerHTML = `
                            <h3 class="font-semibold mb-2 text-blue-900 dark:text-blue-50">Complete the update:</h3>
                            <p class="mb-2">Run this command in your terminal:</p>
                            <code class="block p-2 bg-gray-800 text-green-400 rounded font-mono">php artisan panel:update</code>
                            <p class="mt-2 text-sm opacity-90">This command will apply the update and restart your panel.</p>
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