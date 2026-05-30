<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Setup — UltaVPN Reseller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/app.css" />
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 text-gray-900 font-sans antialiased">

    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-500 mb-4">
                    <span class="text-2xl font-extrabold text-white">U</span>
                </div>
                <h1 class="text-3xl font-extrabold mb-2">Setup UltaVPN Reseller</h1>
                <p class="text-gray-600">Enter your website name and API key to get started</p>
            </div>

            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <div class="text-red-500 mt-0.5">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-red-900 mb-1">Setup Error</h3>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>&bull; {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <div class="text-red-500 mt-0.5">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-red-900">{{ session('error') }}</h3>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="/setup" method="POST" class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
                @csrf

                <!-- Website Name -->
                <div>
                    <label for="website_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Website Name
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="website_name"
                        name="website_name"
                        value="{{ old('website_name', 'UltaVPN Reseller') }}"
                        placeholder="e.g., My VPN Reseller"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('website_name') border-red-500 @enderror"
                        required
                    />
                    @error('website_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">This name will appear throughout your dashboard and website</p>
                </div>

                <!-- Website URL (Auto-detected) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Website URL (Auto-detected)
                    </label>
                    <input
                        type="url"
                        value="{{ $siteUrl }}"
                        class="w-full px-4 py-3 border border-gray-200 bg-gray-50 text-gray-500 rounded-xl cursor-not-allowed focus:outline-none"
                        readonly
                        disabled
                    />
                    <p class="text-gray-500 text-xs mt-1">This is the domain where you uploaded the script. It will automatically be configured as your APP_URL in .env.</p>
                </div>

                <!-- API Key -->
                <div>
                    <label for="api_key" class="block text-sm font-semibold text-gray-700 mb-2">
                        API Key
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="password"
                        id="api_key"
                        name="api_key"
                        value="{{ old('api_key') }}"
                        placeholder="ultavpn_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('api_key') border-red-500 @enderror"
                        required
                    />
                    @error('api_key')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Your reseller API key from the UltaVPN dashboard</p>

                    <!-- Show/Hide Toggle -->
                    <div class="mt-2">
                        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                            <input type="checkbox" id="toggle-api-key" class="w-4 h-4 rounded border-gray-300 text-orange-500">
                            <span>Show API Key</span>
                        </label>
                    </div>
                </div>

                <!-- Test Connection Button -->
                <div>
                    <button
                        type="button"
                        id="test-connection"
                        class="w-full px-4 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Test Connection
                    </button>
                    <div id="test-result" class="mt-2 text-sm hidden"></div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex gap-3">
                        <div class="text-blue-500 flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-900 text-sm mb-1">Need API Credentials?</h4>
                            <p class="text-blue-700 text-xs leading-relaxed">
                                Contact your UltaVPN account manager or visit your
                                <a href="https://ultavpn.com/dashboard" target="_blank" class="underline hover:text-blue-900">UltaVPN Dashboard</a>
                                to generate API credentials.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    id="submit-btn"
                    class="w-full px-4 py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-orange-200 transition flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Complete Setup
                </button>
            </form>

            <!-- Footer -->
            <p class="text-center text-gray-500 text-xs mt-6">
                Setup will securely store your credentials and validate the API connection.
            </p>
        </div>
    </div>

    <script>
        // Toggle API Key visibility
        document.getElementById('toggle-api-key').addEventListener('change', function() {
            const apiKeyInput = document.getElementById('api_key');
            apiKeyInput.type = this.checked ? 'text' : 'password';
        });

        // Test connection
        document.getElementById('test-connection').addEventListener('click', async function() {
            const apiKey = document.getElementById('api_key').value;
            const testResult = document.getElementById('test-result');

            if (!apiKey) {
                testResult.innerHTML = '<span class="text-red-600">Please fill in your API Key first</span>';
                testResult.classList.remove('hidden');
                return;
            }

            this.disabled = true;
            this.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> Testing...';

            try {
                const response = await fetch('/api/setup/test-connection', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify({ api_key: apiKey }),
                });

                const data = await response.json();

                if (data.success) {
                    testResult.innerHTML = `
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-green-700 font-medium">API connection successful!</span>
                        </div>
                    `;
                } else {
                    testResult.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 flex items-start gap-2">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-red-700">${data.message || 'Connection failed'}</span>
                        </div>
                    `;
                }
            } catch (err) {
                testResult.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-red-700">Error: ${err.message}</span>
                    </div>
                `;
            } finally {
                this.disabled = false;
                this.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> Test Connection';
                testResult.classList.remove('hidden');
            }
        });
    </script>

</body>
</html>
