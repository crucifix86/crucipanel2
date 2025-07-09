<div>
    <select wire:change="selectTheme($event.target.value)" class="text-sm bg-transparent border border-gray-300 dark:border-gray-600 rounded px-2 py-1 text-gray-700 dark:text-gray-300 focus:outline-none focus:border-gray-500">
        @foreach($themes as $key => $theme)
            <option value="{{ $key }}" {{ $currentTheme === $key ? 'selected' : '' }}>{{ $theme['name'] }}</option>
        @endforeach
    </select>
</div>