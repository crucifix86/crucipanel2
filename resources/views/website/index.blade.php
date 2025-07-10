<x-hrace009::layouts.portal>
    <x-slot name="slotNewsContent">
        @if( $news->items() )
            @foreach( $news as $article )
                <!-- Single News Block -->
                <div class="news-one">
                    <div class="row vertical-gutter">
                        <div class="col-md-4">
                            <a href="{{ route('show.article', $article->slug) }}" class="angled-img">
                                <div class="img">
                                    @if($article->og_image)
                                        <img src="{{ asset('uploads/og_image') . '/' . $article->og_image }}" alt="">
                                    @else
                                        <img src="{{ asset(config('pw-config.news.default_og_logo', 'img/logo/crucifix_logo.svg')) }}" alt="Default">
                                    @endif
                                </div>
                            </a>
                        </div>
                        <div class="col-md-8">
                            <div class="clearfix">
                                <h3 class="h2 pull-left m-0"><a
                                        href="{{ route('show.article', $article->slug ) }}">{{ strtoupper($article->title) }}</a>
                                </h3>
                                <span class="date pull-right"><i class="fa fa-calendar"></i> {{ $article->date( $article->created_at ) }}</span>
                            </div>
                            <div class="embed-item">
                                <svg class="svg-inline--fa fa-bookmark fa-w-12 meta-icon" aria-hidden="true"
                                     data-prefix="fa" data-icon="bookmark" role="img" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 384 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                          d="M0 512V48C0 21.49 21.49 0 48 0h288c26.51 0 48 21.49 48 48v464L192 400 0 512z"></path>
                                </svg><!-- <i class="fa fa-bookmark meta-icon"></i> -->
                                <span class="label label-{{ $article->categoryColor($article->category) }}"><a
                                        href="{{ route('show.article.by.category', $article->category) }}">{{ __('news.category.' . $article->category) }}</a></span>
                            </div>
                            <div class="tags">
                                <i class="fa fa-tags"></i>
                                @foreach( $article->tags($article->keywords) as $tag )
                                    <a href="{{ route( 'show.article.tag', $tag ) }}">{{ $tag }}</a>{{ $loop->last ? '' : ', ' }}
                                @endforeach
                            </div>
                            <div class="description">
                                {{ $article->description }}
                            </div>
                            <a href="{{ route('show.article', $article->slug ) }}"
                               class="btn read-more pull-left">{{ __('news.readmore') }}</a>
                        </div>
                    </div>
                </div>
                <!-- /Single News Block -->
            @endforeach
        @else
            <div class="no-news-message text-center">
                <h3>{{ __('news.noNews') }}</h3>
                <p>{{ __('news.try') }}</p>
            </div>
        @endif
        <!-- Pagination -->
        {{ $news->links('vendor.pagination.portal') }}
        <!-- /Pagination -->
    </x-slot>

    <x-slot name="slotWidgetContent">
        <x-hrace009::portal.widget/>
    </x-slot>
</x-hrace009::layouts.portal>
