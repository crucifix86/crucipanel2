@extends('layouts.mystical')

@section('body-class', 'messages-page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">{{ __('messages.original_message') }}</div>
                <div class="card-body">
                    <p><strong>{{ __('messages.from') }}:</strong> {{ $message->sender->truename ?? $message->sender->name }}</p>
                    <p><strong>{{ __('messages.subject') }}:</strong> {{ $message->subject ?? __('messages.no_subject') }}</p>
                    <p><strong>{{ __('messages.date') }}:</strong> {{ $message->created_at->format('Y-m-d H:i:s') }}</p>
                    <hr>
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($message->message)) !!}
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">{{ __('messages.reply_to_message') }}</h2>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('messages.reply.store', $message) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="message">{{ __('messages.message') }}</label>
                            <textarea name="message" id="message" rows="5" 
                                      class="form-control @error('message') is-invalid @enderror" 
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane mr-2"></i>{{ __('messages.send_reply') }}
                            </button>
                            <a href="{{ route('messages.show', $message) }}" class="btn btn-secondary">
                                {{ __('messages.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection