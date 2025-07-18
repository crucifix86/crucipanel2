@extends('layouts.mystical')

@section('title', __('messages.my_messages') . ' - ' . config('pw-config.server_name', 'Haven Perfect World'))

@section('body-class', 'messages-page')

@section('content')
<div class="content-section">
    <h2 class="section-title">{{ __('messages.my_messages') }}</h2>
    
    <!-- Tab Navigation -->
    <div class="tab-navigation">
        <button class="tab-button active" onclick="switchTab('inbox', event)">
            <i class="fas fa-inbox"></i> {{ __('messages.inbox') }}
            @if(Auth::user()->unread_message_count > 0)
                <span class="unread-badge">{{ Auth::user()->unread_message_count }}</span>
            @endif
        </button>
        <button class="tab-button" onclick="switchTab('outbox', event)">
            <i class="fas fa-paper-plane"></i> {{ __('messages.outbox') }}
        </button>
        <button class="tab-button" onclick="switchTab('compose', event)">
            <i class="fas fa-pen"></i> {{ __('messages.compose') }}
        </button>
    </div>

    <!-- Tab Contents -->
    <div class="tab-contents">
        <!-- Inbox Tab -->
        <div id="inbox-tab" class="tab-content active">
            @if($inbox->count() > 0)
                <div class="messages-table">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>{{ __('messages.from') }}</th>
                                <th>{{ __('messages.subject') }}</th>
                                <th>{{ __('messages.date') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inbox as $message)
                            <tr class="{{ !$message->is_read ? 'unread-message' : '' }}">
                                <td>{{ $message->sender->truename ?? $message->sender->name }}</td>
                                <td>{{ $message->subject ?? __('messages.no_subject') }}</td>
                                <td>{{ $message->created_at->diffForHumans() }}</td>
                                <td class="actions">
                                    <a href="{{ route('messages.show', $message) }}" class="action-btn view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" 
                                                onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrapper">
                    {{ $inbox->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox fa-4x"></i>
                    <p>{{ __('messages.no_messages') }}</p>
                </div>
            @endif
        </div>

        <!-- Outbox Tab -->
        <div id="outbox-tab" class="tab-content">
            @if($outbox->count() > 0)
                <div class="messages-table">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>{{ __('messages.to') }}</th>
                                <th>{{ __('messages.subject') }}</th>
                                <th>{{ __('messages.date') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($outbox as $message)
                            <tr>
                                <td>{{ $message->recipient->truename ?? $message->recipient->name }}</td>
                                <td>{{ $message->subject ?? __('messages.no_subject') }}</td>
                                <td>{{ $message->created_at->diffForHumans() }}</td>
                                <td class="actions">
                                    <a href="{{ route('messages.show', $message) }}" class="action-btn view">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" 
                                                onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pagination-wrapper">
                    {{ $outbox->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-paper-plane fa-4x"></i>
                    <p>{{ __('messages.no_sent_messages') }}</p>
                </div>
            @endif
        </div>

        <!-- Compose Tab -->
        <div id="compose-tab" class="tab-content">
            <form action="{{ route('messages.store') }}" method="POST" class="message-form">
                @csrf
                
                <div class="form-group">
                    <label for="recipient">{{ __('messages.to') }}</label>
                    <select name="recipient_id" id="recipient" class="form-control" required>
                        <option value="">{{ __('messages.select_recipient') }}</option>
                        @foreach(\App\Models\User::where('ID', '!=', Auth::id())->orderBy('name')->get() as $user)
                            <option value="{{ $user->ID }}" {{ old('recipient_id') == $user->ID ? 'selected' : '' }}>
                                {{ $user->truename ?? $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('recipient_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="subject">{{ __('messages.subject') }}</label>
                    <input type="text" name="subject" id="subject" class="form-control" 
                           value="{{ old('subject') }}" placeholder="{{ __('messages.subject_optional') }}">
                    @error('subject')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="message">{{ __('messages.message') }}</label>
                    <textarea name="message" id="message" rows="5" 
                              class="form-control" required>{{ old('message') }}</textarea>
                    @error('message')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="action-button primary">
                        <i class="fas fa-paper-plane"></i> {{ __('messages.send') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function switchTab(tabId, event) {
    event.preventDefault();
    
    // Remove active class from all buttons and contents
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    
    // Add active class to clicked button and corresponding content
    event.target.closest('.tab-button').classList.add('active');
    document.getElementById(tabId + '-tab').classList.add('active');
    
    // Save active tab
    localStorage.setItem('activeMessageTab', tabId);
}

// Restore active tab on page load
document.addEventListener('DOMContentLoaded', function() {
    const activeTab = localStorage.getItem('activeMessageTab') || 'inbox';
    const tabButton = document.querySelector(`.tab-button[onclick*="${activeTab}"]`);
    if (tabButton) {
        tabButton.click();
    }
    
    // Handle success messages
    @if(session('success'))
        // Show success notification or handle as needed
    @endif
});
</script>
@endsection