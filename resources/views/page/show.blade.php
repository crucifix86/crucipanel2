<x-hrace009.layouts.portal>
    <x-slot name="title">{{ $page->title }} - {{ config('pw-config.server_name') }}</x-slot>
    <x-slot name="description">{{ $page->meta_description ?: $page->title }}</x-slot>
    <x-slot name="keywords">{{ $page->meta_keywords ?: $page->title }}</x-slot>
    <x-slot name="og_url">{{ url()->current() }}</x-slot>
    <x-slot name="og_image">{{ asset(config('pw-config.news.default_og_logo', 'img/logo/crucifix_logo.svg')) }}</x-slot>
    <x-slot name="author">{{ config('pw-config.server_name') }}</x-slot>

    <x-slot name="slotNewsContent">
        <div class="news-article-section">
            <div class="news-article-card">
                {{-- Page Header --}}
                <header class="news-article-header">
                    <h1 class="news-article-title">
                        {{ $page->title }}
                    </h1>
                    <div class="news-article-meta">
                        <span class="news-article-date">
                            <i class="far fa-calendar-alt"></i> {{ __('general.last_updated') }}: {{ $page->updated_at->format('F d, Y') }}
                        </span>
                    </div>
                </header>

                {{-- Page Content --}}
                <article class="news-article-content">
                    <div class="page-content">
                        {!! $page->content !!}
                    </div>
                </article>

                {{-- Back to Home --}}
                <div class="news-article-footer">
                    <a href="{{ route('HOME') }}" class="btn-back-home">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('general.back_to_home') }}
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="slotWidgetContent">
        <x-hrace009::portal.widget/>
    </x-slot>
</x-hrace009.layouts.portal>