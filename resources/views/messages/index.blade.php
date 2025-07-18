@extends('layouts.mystical')

@section('body-class', 'messages-page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">{{ __('messages.my_messages') }}</h2>
                </div>
                
                <div class="card-body">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-4" id="messagesTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="inbox-tab" data-toggle="tab" href="#inbox" role="tab">
                                <i class="fas fa-inbox"></i> {{ __('messages.inbox') }}
                                @if(Auth::user()->unread_message_count > 0)
                                    <span class="badge badge-warning">{{ Auth::user()->unread_message_count }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="outbox-tab" data-toggle="tab" href="#outbox" role="tab">
                                <i class="fas fa-paper-plane"></i> {{ __('messages.outbox') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="compose-tab" data-toggle="tab" href="#compose" role="tab">
                                <i class="fas fa-pen"></i> {{ __('messages.compose') }}
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="messagesTabContent">
                        <!-- Inbox Tab -->
                        <div class="tab-pane fade show active" id="inbox" role="tabpanel">
                            @if($inbox->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
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
                                            <tr class="{{ !$message->is_read ? 'font-weight-bold' : '' }}">
                                                <td>{{ $message->sender->truename ?? $message->sender->name }}</td>
                                                <td>{{ $message->subject ?? __('messages.no_subject') }}</td>
                                                <td>{{ $message->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary view-message" 
                                                            data-message-id="{{ $message->id }}"
                                                            data-toggle="modal" 
                                                            data-target="#messageModal">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <form action="{{ route('messages.destroy', $message) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
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
                                {{ $inbox->links() }}
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                    <p class="text-muted">{{ __('messages.no_messages') }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Outbox Tab -->
                        <div class="tab-pane fade" id="outbox" role="tabpanel">
                            @if($outbox->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
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
                                                <td>
                                                    <button class="btn btn-sm btn-primary view-message" 
                                                            data-message-id="{{ $message->id }}"
                                                            data-toggle="modal" 
                                                            data-target="#messageModal">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <form action="{{ route('messages.destroy', $message) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
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
                                {{ $outbox->links() }}
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-paper-plane fa-4x text-muted mb-3"></i>
                                    <p class="text-muted">{{ __('messages.no_sent_messages') }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Compose Tab -->
                        <div class="tab-pane fade" id="compose" role="tabpanel">
                            <form action="{{ route('messages.store') }}" method="POST">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="recipient">{{ __('messages.to') }}</label>
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.view_message') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="messageContent">
                <!-- Content loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                <button type="button" class="btn btn-primary" id="replyButton" style="display:none;">
                    <i class="fas fa-reply mr-2"></i>{{ __('messages.reply') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.reply_to_message') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="replyForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="replyMessage">{{ __('messages.message') }}</label>
                        <textarea name="message" id="replyMessage" rows="5" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane mr-2"></i>{{ __('messages.send_reply') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('footer')
<script>
$(document).ready(function() {
    // View message in modal
    $('.view-message').click(function() {
        var messageId = $(this).data('message-id');
        var row = $(this).closest('tr');
        
        $.ajax({
            url: '/messages/' + messageId + '/ajax',
            method: 'GET',
            success: function(response) {
                $('#messageContent').html(response.html);
                
                // Show reply button only for received messages
                if (response.can_reply) {
                    $('#replyButton').show().data('message-id', messageId);
                } else {
                    $('#replyButton').hide();
                }
                
                // Mark as read
                row.removeClass('font-weight-bold');
            }
        });
    });
    
    // Reply button click
    $('#replyButton').click(function() {
        var messageId = $(this).data('message-id');
        $('#replyForm').attr('action', '/messages/' + messageId + '/reply');
        $('#messageModal').modal('hide');
        $('#replyModal').modal('show');
    });
    
    // Handle success/error messages
    @if(session('success'))
        // Show success message and stay on current tab
        var activeTab = localStorage.getItem('activeMessageTab') || 'inbox';
        $('#' + activeTab + '-tab').tab('show');
    @endif
    
    // Remember active tab
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var tabId = $(e.target).attr('href').substring(1);
        localStorage.setItem('activeMessageTab', tabId);
    });
    
    // Restore active tab
    var activeTab = localStorage.getItem('activeMessageTab') || 'inbox';
    $('#' + activeTab + '-tab').tab('show');
});
</script>
@endsection