@section('title', ' - Theme Manager')
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('Theme Manager') }}</h1>
            <div class="flex gap-2">
                <form action="{{ route('admin.themes.reset-all-users') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to reset all users to the default theme? This will clear all user theme preferences.')"
                            class="px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-md hover:bg-orange-700">
                        <i class="fas fa-users mr-2"></i>Reset All Users
                    </button>
                </form>
                <a href="{{ route('admin.themes.revert-to-safety') }}" 
                   onclick="return confirm('Are you sure you want to revert to the safety theme? This will activate the default theme.')"
                   class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                    <i class="fas fa-shield-alt mr-2"></i>Revert to Safety
                </a>
            </div>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="mx-auto px-4 sm:px-6 md:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Available Themes ({{ $themes->count() }} themes)
                    </h3>
                    
                    @if($themes->count() == 0)
                        <p class="text-gray-600 dark:text-gray-400">No themes found. Please run: php artisan db:seed --class=ThemeSeeder</p>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($themes as $theme)
                            <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $theme->display_name }}
                                    </h4>
                                    <div class="flex items-center gap-2">
                                        @if($theme->is_default)
                                            <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">Safety</span>
                                        @endif
                                        @if($theme->is_active)
                                            <span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Active</span>
                                        @endif
                                        @if($theme->is_auth_theme)
                                            <span class="px-2 py-1 text-xs font-semibold text-purple-800 bg-purple-100 rounded-full">Auth</span>
                                        @endif
                                        @if($theme->is_visible)
                                            <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Visible</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Hidden</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    {{ $theme->description }}
                                </p>
                                
                                <div class="flex flex-col space-y-2">
                                    @if(!$theme->is_default)
                                        <form action="{{ route('admin.themes.toggle-visibility', $theme) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white {{ $theme->is_visible ? 'bg-gray-600 hover:bg-gray-700' : 'bg-green-600 hover:bg-green-700' }} rounded-md">
                                                <i class="fas fa-{{ $theme->is_visible ? 'eye-slash' : 'eye' }} mr-2"></i>
                                                {{ $theme->is_visible ? 'Hide from Users' : 'Show to Users' }}
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(!$theme->is_active)
                                        <form action="{{ route('admin.themes.set-default', $theme) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 rounded-md">
                                                <i class="fas fa-star mr-2"></i>
                                                Set as Site Default
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(!$theme->is_auth_theme)
                                        <form action="{{ route('admin.themes.toggle-auth', $theme) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-md">
                                                <i class="fas fa-lock mr-2"></i>
                                                Set as Auth Theme
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($theme->is_editable)
                                        <a href="{{ route('admin.themes.edit', $theme) }}" class="w-full px-4 py-2 text-sm font-medium text-center text-indigo-600 bg-indigo-100 rounded-md hover:bg-indigo-200">
                                            <i class="fas fa-edit mr-2"></i>Edit
                                        </a>
                                    @endif
                                    
                                    <button type="button" onclick="showCloneModal({{ $theme->id }}, '{{ $theme->display_name }}')" class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                                        <i class="fas fa-copy mr-2"></i>Clone
                                    </button>
                                    
                                    @if(!$theme->is_default && !$theme->is_auth_theme && !$theme->is_active)
                                        <form action="{{ route('admin.themes.destroy', $theme) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this theme? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                                                <i class="fas fa-trash mr-2"></i>Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Clone Modal -->
        <div id="cloneModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form id="cloneForm" method="POST">
                        @csrf
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4" id="modal-title">
                                Clone Theme
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    Cloning: <span id="cloneThemeName" class="font-semibold"></span>
                                </p>
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Internal Name (no spaces, lowercase)
                                    </label>
                                    <input type="text" name="name" id="name" required pattern="[a-z0-9-]+" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md">
                                </div>
                                <div class="mb-4">
                                    <label for="display_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Display Name
                                    </label>
                                    <input type="text" name="display_name" id="display_name" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Clone Theme
                            </button>
                            <button type="button" onclick="hideCloneModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    @push('scripts')
    <script>
        function showCloneModal(themeId, themeName) {
            document.getElementById('cloneThemeName').textContent = themeName;
            document.getElementById('cloneForm').action = '{{ url("/admin/system/themes") }}/' + themeId + '/clone';
            document.getElementById('cloneModal').classList.remove('hidden');
        }

        function hideCloneModal() {
            document.getElementById('cloneModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-hrace009.layouts.admin>