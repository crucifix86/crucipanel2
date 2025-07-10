@section('title', ' - ' . __('Email Configuration'))
<x-hrace009.layouts.admin>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
            <h1 class="text-2xl font-semibold">{{ __('Email Configuration') }}</h1>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="max-w-4xl mx-auto mt-6">
            <x-hrace009::admin.validation-error/>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form method="post" action="{{ route('admin.email.settings.post') }}">
                @csrf
                
                <div class="bg-white dark:bg-primary-darker rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Mail Driver Configuration</h2>
                    
                    <div class="mb-6">
                        <label for="mail_driver" class="block text-sm font-medium mb-2">Mail Driver</label>
                        <select id="mail_driver" name="mail_driver" class="form-select w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600" onchange="toggleMailFields(this.value)">
                            <option value="smtp" {{ $mailConfig['driver'] == 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="mail" {{ $mailConfig['driver'] == 'mail' ? 'selected' : '' }}>PHP Mail (Free)</option>
                            <option value="sendmail" {{ $mailConfig['driver'] == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                            <option value="log" {{ $mailConfig['driver'] == 'log' ? 'selected' : '' }}>Log (Testing only)</option>
                            <option value="mailgun" {{ $mailConfig['driver'] == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                            <option value="ses" {{ $mailConfig['driver'] == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                        </select>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Choose how emails should be sent</p>
                    </div>

                    <div id="smtp-fields" class="{{ $mailConfig['driver'] != 'smtp' ? 'hidden' : '' }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="mail_host" class="block text-sm font-medium mb-2">SMTP Host</label>
                                <input type="text" id="mail_host" name="mail_host" value="{{ $mailConfig['host'] }}" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="smtp.gmail.com">
                            </div>
                            <div>
                                <label for="mail_port" class="block text-sm font-medium mb-2">SMTP Port</label>
                                <input type="number" id="mail_port" name="mail_port" value="{{ $mailConfig['port'] }}" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="587">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="mail_username" class="block text-sm font-medium mb-2">SMTP Username</label>
                                <input type="text" id="mail_username" name="mail_username" value="{{ $mailConfig['username'] }}" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="your-email@gmail.com">
                            </div>
                            <div>
                                <label for="mail_password" class="block text-sm font-medium mb-2">SMTP Password</label>
                                <input type="password" id="mail_password" name="mail_password" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="Leave blank to keep current">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">For Gmail, use an App Password</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="mail_encryption" class="block text-sm font-medium mb-2">Encryption</label>
                            <select id="mail_encryption" name="mail_encryption" class="form-select w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600">
                                <option value="tls" {{ $mailConfig['encryption'] == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ $mailConfig['encryption'] == 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="" {{ !$mailConfig['encryption'] || $mailConfig['encryption'] == 'null' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>

                    <div class="border-t pt-4 mt-6">
                        <h3 class="text-lg font-semibold mb-4">Sender Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="mail_from_address" class="block text-sm font-medium mb-2">From Email Address</label>
                                <input type="email" id="mail_from_address" name="mail_from_address" value="{{ $mailConfig['from_address'] }}" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="noreply@yourdomain.com" required>
                            </div>
                            <div>
                                <label for="mail_from_name" class="block text-sm font-medium mb-2">From Name</label>
                                <input type="text" id="mail_from_name" name="mail_from_name" value="{{ $mailConfig['from_name'] }}" 
                                       class="form-input w-full rounded-md border-gray-300 dark:bg-primary-darkest dark:border-gray-600"
                                       placeholder="{{ config('pw-config.server_name') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-primary-darker rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Free Email Service Options</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-2">PHP Mail (100% Free)</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Unlimited emails - No external service</p>
                            <button type="button" onclick="setPhpMailConfig()" class="btn btn-sm btn-secondary">Use PHP Mail</button>
                            <div class="mt-2 text-xs text-gray-600">
                                <p>✓ No configuration needed</p>
                                <p>✓ Works on most servers</p>
                                <p>⚠️ May go to spam folder</p>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-2">Gmail (Free)</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Up to 500 emails/day</p>
                            <button type="button" onclick="setGmailConfig()" class="btn btn-sm btn-secondary">Use Gmail Settings</button>
                            <div class="mt-2 text-xs text-gray-600">
                                <p>1. Enable 2FA on your Google account</p>
                                <p>2. Generate app password at myaccount.google.com/apppasswords</p>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-2">SendGrid (Free tier)</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">100 emails/day free</p>
                            <button type="button" onclick="setSendGridConfig()" class="btn btn-sm btn-secondary">Use SendGrid Settings</button>
                            <div class="mt-2 text-xs text-gray-600">
                                <p>1. Sign up at sendgrid.com</p>
                                <p>2. Create API key in Settings</p>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-2">Mailgun (Free trial)</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">5,000 emails/month for 3 months</p>
                            <button type="button" onclick="setMailgunConfig()" class="btn btn-sm btn-secondary">Use Mailgun Settings</button>
                            <div class="mt-2 text-xs text-gray-600">
                                <p>1. Sign up at mailgun.com</p>
                                <p>2. Get SMTP credentials from domain settings</p>
                            </div>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold mb-2">Log Driver (Testing)</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Emails saved to log file</p>
                            <button type="button" onclick="setLogConfig()" class="btn btn-sm btn-secondary">Use Log Driver</button>
                            <div class="mt-2 text-xs text-gray-600">
                                <p>Emails will be saved to storage/logs/laravel.log</p>
                                <p>Perfect for testing without sending real emails</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="testEmailConfig()" class="btn btn-secondary">
                        Test Configuration
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save Configuration
                    </button>
                </div>
            </form>
        </div>
    </x-slot>

    @push('scripts')
    <script>
        function toggleMailFields(driver) {
            const smtpFields = document.getElementById('smtp-fields');
            if (driver === 'smtp') {
                smtpFields.classList.remove('hidden');
            } else {
                smtpFields.classList.add('hidden');
            }
        }

        function setPhpMailConfig() {
            document.getElementById('mail_driver').value = 'mail';
            toggleMailFields('mail');
            alert('PHP Mail selected. No additional configuration needed! Just add your From Email and From Name below.');
        }

        function setGmailConfig() {
            document.getElementById('mail_driver').value = 'smtp';
            document.getElementById('mail_host').value = 'smtp.gmail.com';
            document.getElementById('mail_port').value = '587';
            document.getElementById('mail_encryption').value = 'tls';
            toggleMailFields('smtp');
            alert('Gmail settings applied. Enter your email and app password.');
        }

        function setSendGridConfig() {
            document.getElementById('mail_driver').value = 'smtp';
            document.getElementById('mail_host').value = 'smtp.sendgrid.net';
            document.getElementById('mail_port').value = '587';
            document.getElementById('mail_username').value = 'apikey';
            document.getElementById('mail_encryption').value = 'tls';
            toggleMailFields('smtp');
            alert('SendGrid settings applied. Enter your API key as the password.');
        }

        function setMailgunConfig() {
            document.getElementById('mail_driver').value = 'smtp';
            document.getElementById('mail_host').value = 'smtp.mailgun.org';
            document.getElementById('mail_port').value = '587';
            document.getElementById('mail_encryption').value = 'tls';
            toggleMailFields('smtp');
            alert('Mailgun settings applied. Enter your credentials.');
        }

        function setLogConfig() {
            document.getElementById('mail_driver').value = 'log';
            toggleMailFields('log');
            alert('Log driver selected. Emails will be saved to log file.');
        }

        function testEmailConfig() {
            const testEmail = prompt('Enter email address to send test email to:');
            if (!testEmail) return;

            fetch('{{ route('admin.email.test') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ test_email: testEmail })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Success: ' + data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        }
    </script>
    @endpush
</x-hrace009.layouts.admin>