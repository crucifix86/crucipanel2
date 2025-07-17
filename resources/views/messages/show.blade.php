@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ __('messages.view_message') }}</h2>
                    <a href="{{ route('messages.inbox') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-2"></i>{{ __('messages.back_to_inbox') }}
                    </a>
                </div>
                
                <div class="card-body">
                    <div class="mb-4">
                        <div class="row mb-2">
                            <div class="col-sm-3 font-weight-bold">{{ __('messages.from') }}:</div>
                            <div class="col-sm-9">{{ $message->sender->truename ?? $message->sender->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-3 font-weight-bold">{{ __('messages.to') }}:</div>
                            <div class="col-sm-9">{{ $message->recipient->truename ?? $message->recipient->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-3 font-weight-bold">{{ __('messages.subject') }}:</div>
                            <div class="col-sm-9">{{ $message->subject ?? __('messages.no_subject') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-3 font-weight-bold">{{ __('messages.date') }}:</div>
                            <div class="col-sm-9">{{ $message->created_at->format('Y-m-d H:i:s') }}</div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="message-content p-3 bg-light rounded">
                        {!! nl2br(e($message->message)) !!}
                    </div>
                    
                    <div class="mt-4">
                        @if($message->sender_id !== Auth::id())
                            <a href="{{ route('messages.reply', $message) }}" class="btn btn-primary">
                                <i class="fas fa-reply mr-2"></i>{{ __('messages.reply') }}
                            </a>
                        @endif
                        
                        <form action="{{ route('messages.destroy', $message) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                <i class="fas fa-trash mr-2"></i>{{ __('messages.delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection