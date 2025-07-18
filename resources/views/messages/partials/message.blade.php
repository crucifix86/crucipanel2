<div class="message-details">
    <div class="row mb-3">
        <div class="col-sm-3 font-weight-bold">{{ __('messages.from') }}:</div>
        <div class="col-sm-9">{{ $message->sender->truename ?? $message->sender->name }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-3 font-weight-bold">{{ __('messages.to') }}:</div>
        <div class="col-sm-9">{{ $message->recipient->truename ?? $message->recipient->name }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-3 font-weight-bold">{{ __('messages.subject') }}:</div>
        <div class="col-sm-9">{{ $message->subject ?? __('messages.no_subject') }}</div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-3 font-weight-bold">{{ __('messages.date') }}:</div>
        <div class="col-sm-9">{{ $message->created_at->format('Y-m-d H:i:s') }}</div>
    </div>
    
    <hr>
    
    <div class="message-content">
        {!! nl2br(e($message->message)) !!}
    </div>
    
    @if($message->parent_id)
        <hr>
        <div class="original-message mt-4">
            <h6>{{ __('messages.original_message') }}</h6>
            <div class="bg-light p-3 rounded">
                <small class="text-muted">
                    {{ __('messages.from') }}: {{ $message->parent->sender->truename ?? $message->parent->sender->name }}<br>
                    {{ __('messages.date') }}: {{ $message->parent->created_at->format('Y-m-d H:i:s') }}
                </small>
                <div class="mt-2">
                    {!! nl2br(e($message->parent->message)) !!}
                </div>
            </div>
        </div>
    @endif
</div>