<x-hrace009.layouts.app>
<x-slot name="content">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ __('messages.inbox') }}</h2>
                    <a href="{{ route('messages.compose') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>{{ __('messages.compose') }}
                    </a>
                </div>
                
                <div class="card-body">
                    @if($messages->count() > 0)
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
                                    @foreach($messages as $message)
                                    <tr class="{{ !$message->is_read ? 'font-weight-bold' : '' }}">
                                        <td>{{ $message->sender->truename ?? $message->sender->name }}</td>
                                        <td>{{ $message->subject ?? __('messages.no_subject') }}</td>
                                        <td>{{ $message->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('messages.show', $message) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> {{ __('messages.view') }}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $messages->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <p class="text-muted">{{ __('messages.no_messages') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</x-slot>
</x-hrace009.layouts.app>