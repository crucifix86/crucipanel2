@section('title', ' - Edit Theme: ' . $theme->display_name)
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">Edit Theme: {{ $theme->display_name }}</h1>
            <a href="{{ route('admin.themes.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>Back to Themes
            </a>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="mx-auto px-4 sm:px-6 md:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tabs -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button type="button" onclick="switchTab('css')" id="css-tab" class="tab-button whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm {{ session('active_tab', 'css') == 'css' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            <i class="fas fa-paint-brush mr-2"></i>CSS Editor
                        </button>
                        <button type="button" onclick="switchTab('js')" id="js-tab" class="tab-button whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm {{ session('active_tab') == 'js' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            <i class="fas fa-code mr-2"></i>JavaScript Editor
                        </button>
                        <button type="button" onclick="switchTab('layout')" id="layout-tab" class="tab-button whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm {{ session('active_tab') == 'layout' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            <i class="fas fa-layer-group mr-2"></i>Layout Editor
                        </button>
                    </nav>
                </div>

                <!-- CSS Tab -->
                <div id="css-content" class="tab-content p-6 {{ session('active_tab', 'css') == 'css' ? '' : 'hidden' }}">
                    <form action="{{ route('admin.themes.update', $theme) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tab" value="css">
                        
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">CSS Editor</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Edit the CSS styles for your theme. This controls colors, animations, layout, and all visual styling.
                            </p>
                            <textarea name="css_content" rows="25" class="font-mono text-sm w-full p-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300">{{ $theme->css_content }}</textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                <i class="fas fa-save mr-2"></i>Save CSS
                            </button>
                        </div>
                    </form>
                </div>

                <!-- JavaScript Tab -->
                <div id="js-content" class="tab-content p-6 {{ session('active_tab') == 'js' ? '' : 'hidden' }}">
                    <form action="{{ route('admin.themes.update', $theme) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tab" value="js">
                        
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">JavaScript Editor</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Edit the JavaScript for your theme. This controls interactive features like floating particles, animations, and dynamic behaviors.
                            </p>
                            <textarea name="js_content" rows="25" class="font-mono text-sm w-full p-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300">{{ $theme->js_content }}</textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                <i class="fas fa-save mr-2"></i>Save JavaScript
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Layout Tab -->
                <div id="layout-content" class="tab-content p-6 {{ session('active_tab') == 'layout' ? '' : 'hidden' }}">
                    <form action="{{ route('admin.themes.update', $theme) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tab" value="layout">
                        
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Layout Editor</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                Edit the Blade layout template. This controls the HTML structure, widget positions, and overall page layout.
                            </p>
                            <textarea name="layout_content" rows="25" class="font-mono text-sm w-full p-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300">{{ $theme->layout_content }}</textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                <i class="fas fa-save mr-2"></i>Save Layout
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Tips</h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <ul class="list-disc list-inside space-y-1">
                                <li>CSS changes are saved directly to public/css/mystical-purple-unified.css</li>
                                <li>JavaScript and Layout changes are saved to the database</li>
                                <li>If this is the active theme, changes will be applied to the site instantly</li>
                                <li>You can always revert to the safety theme if something breaks</li>
                                <li>Use Ctrl+F to search within the editor</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @push('scripts')
    <script>
        function switchTab(tab) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active styles from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-indigo-500', 'text-indigo-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tab + '-content').classList.remove('hidden');
            
            // Add active styles to selected tab
            const activeTab = document.getElementById(tab + '-tab');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-indigo-500', 'text-indigo-600');
        }
    </script>
    @endpush
</x-hrace009.layouts.admin>