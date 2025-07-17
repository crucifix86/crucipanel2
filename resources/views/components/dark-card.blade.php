{{-- Dark themed card component for consistent styling --}}
<div {{ $attributes->merge(['class' => 'bg-white dark:bg-card-bg rounded-lg shadow-sm dark:shadow-md p-6 border border-gray-200 dark:border-border-color transition-all duration-200']) }}>
    {{ $slot }}
</div>