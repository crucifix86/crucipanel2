@section('title', ' - Scheduler Settings')
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">Automatic Scheduler</h1>
        </div>
    </x-slot>
    
    <x-slot name="content">
        <div class="max-w mx-auto mt-6 ml-6 mr-6">
            
            @if(request()->get('saved') == 1)
                <div class="bg-green-50 dark:bg-green-900/30 border-2 border-green-500 dark:border-green-400 text-green-900 dark:text-green-100 px-4 py-3 rounded-lg relative mb-4 font-semibold" role="alert">
                    <span class="block sm:inline">✓ Scheduler settings saved successfully!</span>
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = window.location.pathname;
                    }, 2000);
                </script>
            @endif
            
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border-2 border-green-500 dark:border-green-400 text-green-900 dark:text-green-100 px-4 py-3 rounded-lg relative mb-4 font-semibold" role="alert">
                    <span class="block sm:inline">✓ {!! session('success') !!}</span>
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
                        <h3 class="font-bold mb-1">No Cron Job Required!</h3>
                        <p class="text-sm">This built-in scheduler automatically runs background tasks without needing system cron jobs. Tasks run when users visit your site.</p>
                        <p class="text-sm mt-2"><strong>Tasks that run automatically:</strong></p>
                        <ul class="text-sm mt-1 ml-4 list-disc">
                            <li>Transfer processing (every minute)</li>
                            <li>Player rankings update (every hour)</li>
                            <li>Faction rankings update (every hour)</li>
                            <li>Territory map update (every hour)</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Security Key Status -->
            @if(!$hasScheduleKey)
            <div class="bg-yellow-50 dark:bg-yellow-900/30 border-2 border-yellow-500 dark:border-yellow-400 text-yellow-900 dark:text-yellow-100 px-4 py-3 rounded-lg mb-6" role="alert">
                <div class="flex items-start">
                    <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="font-bold mb-1">Security Key Required</h3>
                        <p class="text-sm">The scheduler needs a security key to prevent unauthorized access. Click the button below to generate one automatically.</p>
                        
                        <form method="POST" action="{{ route('admin.scheduler.generateKey') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                Generate Security Key
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Current Status -->
            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Current Status</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Scheduler Status:</p>
                        <p class="text-lg font-semibold {{ $enabled ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $enabled ? 'ENABLED' : 'DISABLED' }}
                        </p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Security Key:</p>
                        <p class="text-lg font-semibold {{ $hasScheduleKey ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $hasScheduleKey ? 'CONFIGURED' : 'NOT SET' }}
                        </p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Currently Running:</p>
                        <p class="text-lg font-semibold {{ $running ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400' }}">
                            {{ $running ? 'YES' : 'NO' }}
                        </p>
                    </div>
                    
                    @if($lastRun && count($lastRun) > 0)
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Last Transfer Update:</p>
                        <p class="text-lg font-semibold">
                            {{ isset($lastRun['transfer']) ? $lastRun['transfer']->diffForHumans() : 'Never' }}
                        </p>
                        @if(isset($lastRun['transfer']) && $lastRun['transfer']->diffInMinutes(now()) > 5)
                            <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                                ⚠️ Should run every minute
                            </p>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Last Rankings Update:</p>
                        <p class="text-lg font-semibold">
                            {{ isset($lastRun['rankings']) ? $lastRun['rankings']->diffForHumans() : 'Never' }}
                        </p>
                        @if(isset($lastRun['rankings']) && $lastRun['rankings']->diffInHours(now()) > 2)
                            <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                                ⚠️ Should run every hour
                            </p>
                        @endif
                    </div>
                    @else
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400">No tasks have run yet.</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Settings Form -->
            <form method="POST" action="{{ route('admin.scheduler.update') }}">
                @csrf
                
                <div class="relative z-0 mb-6 w-full group">
                    <div class="flex items-center">
                        <input type="checkbox" id="enabled" name="enabled" value="1" 
                               {{ $enabled ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="enabled" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Enable Automatic Scheduler
                        </label>
                    </div>
                    <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                        When enabled, scheduled tasks will run automatically in the background when users visit your site.
                    </p>
                </div>
                
                <div class="flex gap-4">
                    <x-hrace009::button-with-popover class="w-auto" popover="Save scheduler settings">
                        Save Settings
                    </x-hrace009::button-with-popover>
                </div>
            </form>
            
            <!-- Tabs -->
            <div class="mt-8 pt-8 border-t border-gray-300 dark:border-gray-600">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="showTab('manual')" id="manual-tab" class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600 dark:text-blue-400">
                            Manual Run
                        </button>
                        <button onclick="showTab('log')" id="log-tab" class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                            Last Run Log
                        </button>
                    </nav>
                </div>
                
                <!-- Manual Run Tab -->
                <div id="manual-content" class="tab-content mt-6">
                    <h3 class="text-lg font-semibold mb-4">Manual Run</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Click the button below to manually run all scheduled tasks immediately.
                    </p>
                    
                    <form method="POST" action="{{ route('admin.scheduler.run') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Run All Tasks Now
                        </button>
                    </form>
                </div>
                
                <!-- Log Tab -->
                <div id="log-content" class="tab-content mt-6" style="display: none;">
                    <h3 class="text-lg font-semibold mb-4">Last Run Log</h3>
                    
                    @if($lastLog)
                        <div class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                            <div class="mb-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Timestamp:</span>
                                <span class="text-sm font-semibold ml-2">{{ $lastLog['timestamp'] }}</span>
                                @php
                                    $lastRunTime = \Carbon\Carbon::parse($lastLog['timestamp']);
                                    $hoursSinceRun = $lastRunTime->diffInHours(now());
                                @endphp
                                <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">({{ $lastRunTime->diffForHumans() }})</span>
                                
                                @if($hoursSinceRun > 24)
                                    <span class="ml-2 text-xs px-2 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded">
                                        ⚠️ Over 24 hours ago
                                    </span>
                                @endif
                                
                                <span class="ml-4 text-sm text-gray-600 dark:text-gray-400">Type:</span>
                                <span class="text-sm font-semibold ml-2 {{ $lastLog['type'] === 'manual' ? 'text-blue-600 dark:text-blue-400' : 'text-green-600 dark:text-green-400' }}">
                                    {{ ucfirst($lastLog['type']) }}
                                </span>
                            </div>
                            
                            <h4 class="text-sm font-semibold mb-2">Task Results:</h4>
                            
                            @foreach($lastLog['tasks'] as $taskName => $taskData)
                                <div class="mb-3 pl-4 border-l-2 {{ $taskData['status'] === 'success' ? 'border-green-500' : 'border-red-500' }}">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium">{{ ucfirst($taskName) }} Update</span>
                                        <span class="text-xs px-2 py-1 rounded {{ $taskData['status'] === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            {{ strtoupper($taskData['status']) }}
                                        </span>
                                    </div>
                                    
                                    @if($taskData['status'] === 'failed' && isset($taskData['error']))
                                        <div class="text-xs text-red-600 dark:text-red-400 mt-1">
                                            Error: {{ $taskData['error'] }}
                                        </div>
                                    @endif
                                    
                                    @if(isset($taskData['output']) && !empty(trim($taskData['output'])))
                                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1 font-mono">
                                            Output: {{ $taskData['output'] }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-gray-600 dark:text-gray-400">
                            No log data available. Run the scheduler manually or wait for an automatic run.
                        </div>
                    @endif
                </div>
            </div>
            
            <script>
                function showTab(tab) {
                    // Hide all content
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.style.display = 'none';
                    });
                    
                    // Remove active state from all tabs
                    document.querySelectorAll('.tab-button').forEach(button => {
                        button.classList.remove('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                        button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                    });
                    
                    // Show selected content
                    document.getElementById(tab + '-content').style.display = 'block';
                    
                    // Add active state to selected tab
                    const activeTab = document.getElementById(tab + '-tab');
                    activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                    activeTab.classList.add('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                }
            </script>
            
        </div>
    </x-slot>
</x-hrace009.layouts.admin>