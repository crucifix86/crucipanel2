@extends('layouts.mystical')

@section('title', config('pw-config.server_name', 'Haven Perfect World') . ' - ' . __('Faction Icons'))

@section('body-class', 'faction-icons-page')

@section('content')
<div class="container">
    <div class="content-section">
        <h3>{{ __('Faction Icon Upload') }}</h3>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($factions->isEmpty())
                <div class="alert alert-info">
                    {{ __('You must be a faction master to upload faction icons.') }}
                </div>
            @else
                <div class="faction-icon-info">
                    <h4>{{ __('Upload Requirements') }}</h4>
                    <ul>
                        <li>{{ __('Image size:') }} {{ $settings->icon_size }}x{{ $settings->icon_size }}px</li>
                        <li>{{ __('Max file size:') }} {{ $settings->getMaxFileSizeInMb() }}MB</li>
                        <li>{{ __('Allowed formats:') }} {{ implode(', ', $settings->allowed_formats) }}</li>
                        <li>{{ __('Cost:') }} {{ $settings->getCostDisplay() }}</li>
                        @if($settings->require_approval)
                            <li class="text-warning">{{ __('Admin approval required') }}</li>
                        @endif
                    </ul>
                </div>
                
                <div class="faction-icon-upload">
                    <h4>{{ __('Your Factions') }}</h4>
                    <div class="alert alert-info">
                        Debug: Found {{ $factions->count() }} factions<br>
                        @foreach($factions as $faction)
                            Faction: {{ json_encode($faction) }}<br>
                        @endforeach
                    </div>
                    
                    @foreach($factions as $faction)
                        <div class="faction-item mb-4 p-3 border rounded">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5>{{ $faction->name }}</h5>
                                    <small class="text-muted">{{ __('Members:') }} {{ $faction->members }}</small>
                                </div>
                                <div class="col-md-6 text-right">
                                    @php
                                        $currentIcon = $iconSubmissions->where('faction_id', $faction->id)->first();
                                    @endphp
                                    
                                    @if($currentIcon)
                                        @if($currentIcon->isPending())
                                            <div class="mb-2">
                                                <span class="badge badge-warning">{{ __('Pending Approval') }}</span>
                                            </div>
                                            <form action="{{ route('faction-icons.cancel', $currentIcon->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure you want to cancel this submission?') }}')">
                                                    {{ __('Cancel Submission') }}
                                                </button>
                                            </form>
                                        @elseif($currentIcon->isApproved())
                                            <div class="mb-2">
                                                <img src="{{ $currentIcon->getIconUrl() }}" alt="{{ $faction->name }}" class="faction-icon-preview">
                                                <span class="badge badge-success">{{ __('Active') }}</span>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-primary upload-icon-btn" data-faction-id="{{ $faction->id }}" data-faction-name="{{ $faction->name }}">
                                                {{ __('Change Icon') }}
                                            </button>
                                        @elseif($currentIcon->isRejected())
                                            <div class="mb-2">
                                                <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                                @if($currentIcon->rejection_reason)
                                                    <small class="d-block text-danger">{{ $currentIcon->rejection_reason }}</small>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-sm btn-primary upload-icon-btn" data-faction-id="{{ $faction->id }}" data-faction-name="{{ $faction->name }}">
                                                {{ __('Upload New Icon') }}
                                            </button>
                                        @endif
                                    @else
                                        <button type="button" class="btn btn-sm btn-primary upload-icon-btn" data-faction-id="{{ $faction->id }}" data-faction-name="{{ $faction->name }}">
                                            {{ __('Upload Icon') }}
                                        </button>
                                        <small class="text-muted d-block">Debug: ID={{ $faction->id }}, Name={{ $faction->name }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($iconSubmissions->isNotEmpty())
                    <div class="faction-icon-history mt-5">
                        <h4>{{ __('Submission History') }}</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Faction') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Submitted') }}</th>
                                    <th>{{ __('Reviewed By') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($iconSubmissions as $submission)
                                    <tr>
                                        <td>{{ $factions->firstWhere('id', $submission->faction_id)->name ?? 'Unknown' }}</td>
                                        <td>
                                            @if($submission->isPending())
                                                <span class="badge badge-warning">{{ __('Pending') }}</span>
                                            @elseif($submission->isApproved())
                                                <span class="badge badge-success">{{ __('Approved') }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $submission->created_at->diffForHumans() }}</td>
                                        <td>{{ $submission->approver->name ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">{{ __('Upload Faction Icon') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div id="uploadStatus" class="alert alert-info" style="min-height: 50px;">Waiting for action...</div>
                    <div class="form-group">
                        <label>{{ __('Faction:') }} <span id="factionName"></span></label>
                        <input type="hidden" name="faction_id" id="factionId">
                    </div>
                    
                    <div class="form-group">
                        <label for="iconFile">{{ __('Select Image') }}</label>
                        <input type="file" class="form-control-file" id="iconFile" name="icon" accept="image/*" required>
                        <small class="form-text text-muted">
                            {{ __('Size:') }} {{ $settings->icon_size }}x{{ $settings->icon_size }}px, 
                            {{ __('Max:') }} {{ $settings->getMaxFileSizeInMb() }}MB
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <div id="imagePreview" class="text-center" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px;">
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        {{ __('Cost:') }} {{ $settings->getCostDisplay() }}
                        @if($settings->require_approval)
                            <br>{{ __('Note: Payment will be processed after admin approval.') }}
                        @else
                            <br>{{ __('Note: Payment will be processed immediately.') }}
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary" id="uploadBtn">{{ __('Upload') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<style>
    .faction-icon-preview {
        width: 24px;
        height: 24px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 5px;
    }
    
    .faction-item {
        background: rgba(255, 255, 255, 0.05);
    }
    
    .faction-icon-info {
        background: rgba(147, 112, 219, 0.1);
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .faction-icon-info ul {
        list-style: none;
        padding-left: 0;
    }
    
    .faction-icon-info li:before {
        content: "✓ ";
        color: #9370db;
        font-weight: bold;
    }
</style>
<script>
window.onload = function() {
    // Test if JS is working at all
    var statusDiv = document.getElementById('uploadStatus');
    if (statusDiv) {
        statusDiv.innerHTML = 'JavaScript loaded!';
    }
    
    // Wait for jQuery
    if (typeof jQuery === 'undefined') {
        if (statusDiv) {
            statusDiv.innerHTML = 'ERROR: jQuery not loaded!';
        }
        return;
    }
    
    jQuery(document).ready(function($) {
        // Check if hidden input exists
        var hiddenInput = $('#factionId');
        if (hiddenInput.length === 0) {
            $('#uploadStatus').html('ERROR: Hidden faction ID input not found!');
        } else {
            $('#uploadStatus').html('jQuery loaded! Hidden input found. Ready to upload.');
        }
        
        // Show button info in status area
        var buttons = $('.upload-icon-btn');
        $('#uploadStatus').append('<br>Found ' + buttons.length + ' upload buttons on page');
        
        // Handle upload button click - use event delegation for dynamic content
        $(document).on('click', '.upload-icon-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $btn = $(this);
            
            // Try multiple ways to get the faction ID
            var factionId = $btn.attr('data-faction-id');
            var factionName = $btn.attr('data-faction-name');
            
            // Show full button info
            $('#uploadStatus').html('Button clicked. Raw attr faction-id: "' + factionId + '" | Raw attr faction-name: "' + factionName + '"');
            
            // If still no ID, show the actual button element
            if (!factionId) {
                var buttonHTML = $btn[0].outerHTML;
                $('#uploadStatus').html('ERROR: No faction ID found! Full button: ' + buttonHTML.replace(/</g, '&lt;').replace(/>/g, '&gt;'));
                
                // Try to find the button's attributes manually
                var attrs = $btn[0].attributes;
                var attrList = 'Button attributes: ';
                for (var i = 0; i < attrs.length; i++) {
                    attrList += attrs[i].name + '="' + attrs[i].value + '" ';
                }
                $('#uploadStatus').append('<br>All attributes: ' + attrList);
                return;
            }
            
            // Set the hidden input value multiple ways
            $('#factionId').val(factionId);
            document.getElementById('factionId').value = factionId;
            $('#factionId').attr('value', factionId);
            
            $('#factionName').text(factionName);
            
            // Triple check it was set
            var checkId1 = $('#factionId').val();
            var checkId2 = document.getElementById('factionId').value;
            var checkId3 = $('#factionId').attr('value');
            
            $('#uploadStatus').html('Set faction ID: jQuery val()=' + checkId1 + ', native value=' + checkId2 + ', attr value=' + checkId3);
            
            // Open modal after a small delay to ensure values are set
            setTimeout(function() {
                $('#uploadModal').modal('show');
            }, 100);
        });
        
        // Preview image on selection
        $('#iconFile').change(function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#imagePreview').show();
                };
                reader.readAsDataURL(file);
            } else {
                $('#imagePreview').hide();
            }
        });
        
        // Handle form submission
        $('#uploadForm').on('submit', function(e) {
            e.preventDefault();
            
            var $status = $('#uploadStatus');
            var $btn = $('#uploadBtn');
            
            $status.removeClass('alert-success alert-danger').addClass('alert-info').html('Starting upload...');
            
            // Check faction ID - use native JS
            var factionIdInput = document.getElementById('factionId');
            var factionId = factionIdInput ? factionIdInput.value : '';
            
            $status.html('Checking faction ID: Found input = ' + (factionIdInput ? 'yes' : 'no') + ', Value = ' + factionId);
            
            if (!factionId || factionId === '') {
                $status.removeClass('alert-info').addClass('alert-danger').html('Error: No faction ID set! Input exists: ' + (factionIdInput ? 'yes' : 'no'));
                $btn.prop('disabled', false).html('Upload');
                return;
            }
            $status.html('Faction ID: ' + factionId + ' - Creating form data...');
            
            var formData = new FormData(this);
            
            // Explicitly add faction_id in case the hidden field isn't working
            formData.append('faction_id', factionId);
            
            // Log what we're sending
            $status.html('Sending faction ' + factionId + ' with file...');
            
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Uploading...');
            
            $.ajax({
                url: '{{ route('faction-icons.upload') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total * 100;
                            $status.html('Uploading: ' + percentComplete.toFixed(0) + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    $status.removeClass('alert-info').addClass('alert-success');
                    $status.html('Success: ' + response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    $status.removeClass('alert-info').addClass('alert-danger');
                    var errorMsg = 'Error: ';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMsg += xhr.responseJSON.error;
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg += xhr.responseJSON.message;
                    } else {
                        errorMsg += 'Upload failed (Status: ' + xhr.status + ')';
                    }
                    $status.html(errorMsg);
                    $btn.prop('disabled', false).html('Upload');
                }
            });
        });
        
        // Check value when modal opens
        $('#uploadModal').on('shown.bs.modal', function() {
            var modalCheckId = document.getElementById('factionId').value;
            $('#uploadStatus').html('Modal opened. Faction ID in hidden input: "' + modalCheckId + '"');
        });
        
        // Reset form when modal is closed
        $('#uploadModal').on('hidden.bs.modal', function() {
            $('#uploadForm')[0].reset();
            $('#imagePreview').hide();
            $('#uploadStatus').removeClass('alert-success alert-danger').addClass('alert-info').html('Waiting for action...');
        });
    });
};
</script>
@endsection