@extends('layouts.mystical')

@section('title', $page->title . ' - ' . config('pw-config.server_name', 'Haven Perfect World'))
@section('meta_description', $page->meta_description ?: $page->title)
@section('meta_keywords', $page->meta_keywords ?: $page->title)

@section('body-class', 'custom-page')

@section('content')
<div class="custom-page-content">
    <div class="page-header">
        <h1 class="page-title">{{ $page->title }}</h1>
        <div class="page-meta">
            <span class="meta-icon">📅</span>
            <span class="meta-text">{{ __('general.last_updated') }}: {{ $page->updated_at->format('F d, Y') }}</span>
        </div>
    </div>
    
    <div class="content-wrapper">
        <div class="page-content">
            {!! $page->content !!}
        </div>
    </div>
    
    @if($page->meta_description || $page->meta_keywords)
    <div class="page-footer">
        @if($page->meta_description)
            <div class="meta-description">
                <span class="meta-label">{{ __('admin.meta_description') }}:</span>
                <span class="meta-value">{{ $page->meta_description }}</span>
            </div>
        @endif
        
        @if($page->meta_keywords)
            <div class="meta-keywords">
                <span class="meta-label">{{ __('admin.meta_keywords') }}:</span>
                <div class="keywords-list">
                    @foreach(explode(',', $page->meta_keywords) as $keyword)
                        <span class="keyword-tag">{{ trim($keyword) }}</span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    @endif
</div>
@endsection

@section('scripts')
@parent
<script>
    // Add smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add animation to images on scroll
    const images = document.querySelectorAll('.page-content img');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.8s ease-out';
                imageObserver.unobserve(entry.target);
            }
        });
    });
    
    images.forEach(img => {
        imageObserver.observe(img);
    });
</script>
@endsection