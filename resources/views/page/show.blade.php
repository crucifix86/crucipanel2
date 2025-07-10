<x-hrace009.layouts.portal>
    <x-slot name="title">{{ $page->title }} - {{ config('pw-config.server_name') }}</x-slot>
    <x-slot name="description">{{ $page->meta_description ?: $page->title }}</x-slot>
    <x-slot name="keywords">{{ $page->meta_keywords ?: $page->title }}</x-slot>
    <x-slot name="og_url">{{ url()->current() }}</x-slot>
    <x-slot name="og_image">{{ asset(config('pw-config.news.default_og_logo', 'img/logo/crucifix_logo.svg')) }}</x-slot>
    <x-slot name="author">{{ config('pw-config.server_name') }}</x-slot>

    <div class="news-article-section py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                {{-- Page Header --}}
                <header class="mb-8">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900 dark:text-white">
                        {{ $page->title }}
                    </h1>
                    <div class="flex items-center text-gray-600 dark:text-gray-400 text-sm">
                        <span>{{ __('general.last_updated') }}: {{ $page->updated_at->format('F d, Y') }}</span>
                    </div>
                </header>

                {{-- Page Content --}}
                <article class="prose prose-lg dark:prose-invert max-w-none">
                    <div class="page-content">
                        {!! $page->content !!}
                    </div>
                </article>

                {{-- Back to Home --}}
                <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('HOME') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('general.back_to_home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-content {
            line-height: 1.8;
        }
        
        .page-content h1,
        .page-content h2,
        .page-content h3,
        .page-content h4,
        .page-content h5,
        .page-content h6 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: bold;
        }
        
        .page-content p {
            margin-bottom: 1rem;
        }
        
        .page-content ul,
        .page-content ol {
            margin-bottom: 1rem;
            padding-left: 2rem;
        }
        
        .page-content li {
            margin-bottom: 0.5rem;
        }
        
        .page-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }
        
        .page-content a {
            color: #3b82f6;
            text-decoration: underline;
        }
        
        .page-content a:hover {
            color: #2563eb;
        }
        
        .dark .page-content a {
            color: #60a5fa;
        }
        
        .dark .page-content a:hover {
            color: #93bbfc;
        }
        
        .page-content blockquote {
            border-left: 4px solid #e5e7eb;
            padding-left: 1rem;
            margin: 1rem 0;
            font-style: italic;
            color: #6b7280;
        }
        
        .dark .page-content blockquote {
            border-left-color: #4b5563;
            color: #9ca3af;
        }
        
        .page-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        
        .page-content table th,
        .page-content table td {
            border: 1px solid #e5e7eb;
            padding: 0.5rem 1rem;
            text-align: left;
        }
        
        .dark .page-content table th,
        .dark .page-content table td {
            border-color: #4b5563;
        }
        
        .page-content table th {
            background-color: #f9fafb;
            font-weight: bold;
        }
        
        .dark .page-content table th {
            background-color: #374151;
        }
        
        .page-content code {
            background-color: #f3f4f6;
            padding: 0.125rem 0.25rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }
        
        .dark .page-content code {
            background-color: #4b5563;
        }
        
        .page-content pre {
            background-color: #f3f4f6;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1rem 0;
        }
        
        .dark .page-content pre {
            background-color: #374151;
        }
        
        .page-content pre code {
            background-color: transparent;
            padding: 0;
        }
    </style>
</x-hrace009.layouts.portal>