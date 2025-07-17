<x-hrace009.layouts.app>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">{{ __('messages.compose') }}</h2>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="recipient">{{ __('messages.to') }}</label>
                            @if($recipient)
                                <input type="hidden" name="recipient_id" value="{{ $recipient->ID }}">
                                <input type="text" class="form-control" value="{{ $recipient->truename ?? $recipient->name }}" readonly>
                            @else
                                <select name="recipient_id" id="recipient" class="form-control @error('recipient_id') is-invalid @enderror" required>
                                    <option value="">{{ __('messages.select_recipient') }}</option>
                                    @foreach(\App\Models\User::where('ID', '!=', Auth::id())->orderBy('name')->get() as $user)
                                        <option value="{{ $user->ID }}" {{ old('recipient_id') == $user->ID ? 'selected' : '' }}>
                                            {{ $user->truename ?? $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('recipient_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">{{ __('messages.subject') }}</label>
                            <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" 
                                   value="{{ old('subject') }}" placeholder="{{ __('messages.subject_optional') }}">
                            @error('subject')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
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
                                <i class="fas fa-paper-plane mr-2"></i>{{ __('messages.send') }}
                            </button>
                            <a href="{{ route('messages.inbox') }}" class="btn btn-secondary">
                                {{ __('messages.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-hrace009.layouts.app>