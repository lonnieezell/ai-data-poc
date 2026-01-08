<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Work-Life Balance and Longevity</title>

        <style>
            /* Message styling */
            .message-content {
                white-space: pre-wrap;
                word-wrap: break-word;
                line-height: 1.5;
            }
            .message-content strong {
                font-weight: 600;
            }
            .message-content em {
                font-style: italic;
            }
        </style>

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */@layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-serif:ui-serif,Georgia,Cambria,"Times New Roman",Times,serif;--font-mono:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;--color-black:#000;--color-white:#fff}}
            </style>
        @endif
    </head>
    <body class="min-h-screen flex bg-white">
        <!-- Sidebar (Left) -->
        <div class="w-64 bg-slate-200 text-slate-900 flex flex-col">
            <!-- Logo/Header -->
            <div class="p-4 border-b border-slate-300">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-slate-700 rounded flex items-center justify-center">
                        <span class="text-sm font-bold text-white">AI</span>
                    </div>
                    <span class="font-semibold text-slate-900">Dataset Chat</span>
                </div>
            </div>

            <!-- New Chat Button -->
            <div class="p-4 border-b border-slate-300">
                <button class="w-full px-4 py-2 bg-slate-300 hover:bg-slate-400 rounded border border-slate-400 text-slate-900 text-sm font-medium transition">
                    + New Chat
                </button>
            </div>

            <!-- Data Reference Section -->
            <div class="flex-1 overflow-y-auto p-4">
                <h3 class="text-xs uppercase tracking-wide text-slate-600 font-semibold mb-4">Available Data Points</h3>
                <div class="space-y-3">
                    <div class="text-xs">
                        <p class="font-medium text-slate-900">Gender</p>
                        <p class="text-slate-600 mt-1">Occupant gender classification</p>
                    </div>
                    <div class="text-xs">
                        <p class="font-medium text-slate-900">Occupation Type</p>
                        <p class="text-slate-600 mt-1">Classification of employment type</p>
                    </div>
                    <div class="text-xs">
                        <p class="font-medium text-slate-900">Daily Work Hours</p>
                        <p class="text-slate-600 mt-1">Average hours worked per day</p>
                    </div>
                    <div class="text-xs">
                        <p class="font-medium text-slate-900">Daily Rest Hours</p>
                        <p class="text-slate-600 mt-1">Average rest hours per day</p>
                    </div>
                    <div class="text-xs">
                        <p class="font-medium text-slate-900">Daily Sleep Hours</p>
                        <p class="text-slate-600 mt-1">Average sleep hours per day</p>
                    </div>
                    <div class="text-xs">
                        <p class="font-medium text-slate-900">Daily Exercise Hours</p>
                        <p class="text-slate-600 mt-1">Average exercise hours per day</p>
                    </div>
                    <div class="text-xs">
                        <p class="font-medium text-slate-900">Age at Death</p>
                        <p class="text-slate-600 mt-1">Subject age when deceased</p>
                    </div>
                </div>

                <!-- Dataset Info -->
                <div class="mt-6 pt-4 border-t border-slate-300">
                    <p class="text-xs text-slate-600">
                        Dataset: 10,000 rows from
                        <a href="https://www.kaggle.com/datasets/oluwatosinadewale/quality-of-life-data" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-700 underline">
                            Kaggle
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Chat Area (Right) -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="px-8 py-6 border-b border-slate-200">
                <h1 class="text-2xl font-semibold text-slate-900">Work-Life Balance and Longevity Dataset</h1>
            </header>

            <!-- Messages Container -->
            <div id="messages" class="flex-1 overflow-y-auto p-8 space-y-4">
                <div class="text-center text-slate-500">
                    <p>Welcome! Ask questions about the dataset.</p>
                </div>
            </div>

            <!-- Input Area -->
            <div class="border-t border-slate-200 p-8">
                <form id="chat-form" class="flex gap-3">
                    <input
                        type="text"
                        id="message-input"
                        placeholder="Ask about the data..."
                        class="flex-1 px-4 py-3 border border-slate-300 rounded bg-white text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required
                        autofocus
                    />
                    <button
                        type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded transition"
                    >
                        Send
                    </button>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('chat-form').addEventListener('submit', async (e) => {
                e.preventDefault();
                const input = document.getElementById('message-input');
                const message = input.value.trim();
                if (!message) return;

                // Add user message to chat
                const messagesContainer = document.getElementById('messages');
                if (messagesContainer.querySelector('.text-center')) {
                    messagesContainer.innerHTML = '';
                }
                const userMessage = document.createElement('div');
                userMessage.className = 'flex justify-end';
                userMessage.innerHTML = `
                    <div class="max-w-md px-4 py-2 rounded-lg bg-blue-600 text-white">
                        ${escapeHtml(message)}
                    </div>
                `;
                messagesContainer.appendChild(userMessage);
                input.value = '';

                // Add loading indicator
                const loadingMessage = document.createElement('div');
                loadingMessage.className = 'flex';
                loadingMessage.innerHTML = `
                    <div class="max-w-md px-4 py-2 rounded-lg bg-slate-200 text-slate-900">
                        <span class="inline-block">Thinking</span><span class="inline-block animate-bounce">.</span><span class="inline-block animate-bounce" style="animation-delay: 0.1s">.</span><span class="inline-block animate-bounce" style="animation-delay: 0.2s">.</span>
                    </div>
                `;
                messagesContainer.appendChild(loadingMessage);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;

                try {
                    const response = await fetch('/chat/stream', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        },
                        body: JSON.stringify({
                            message,
                            thread_id: '{{ session()->getId() }}'
                        }),
                    });

                    const reader = response.body.getReader();
                    const decoder = new TextDecoder();
                    let assistantMessage = document.createElement('div');
                    assistantMessage.className = 'flex';
                    const messageText = document.createElement('div');
                    messageText.className = 'max-w-2xl px-4 py-2 rounded-lg bg-slate-100 text-slate-900 message-content prose prose-sm';
                    assistantMessage.appendChild(messageText);

                    loadingMessage.remove();
                    messagesContainer.appendChild(assistantMessage);

                    let fullResponse = '';

                    while (true) {
                        const { done, value } = await reader.read();
                        if (done) break;

                        const chunk = decoder.decode(value);
                        const lines = chunk.split('\n');
                        for (const line of lines) {
                            if (line.startsWith('data: ')) {
                                try {
                                    const data = JSON.parse(line.slice(6));
                                    fullResponse += data.message;

                                    // Display response as formatted text
                                    messageText.textContent = fullResponse;

                                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                                } catch (e) {
                                    console.error('JSON parse error:', e);
                                    // Invalid JSON, skip
                                }
                            }
                        }
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    loadingMessage.remove();
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'flex';
                    errorMessage.innerHTML = `
                        <div class="max-w-2xl px-4 py-2 rounded-lg bg-red-100 text-red-900">
                            Error: ${escapeHtml(error.message)}
                        </div>
                    `;
                    messagesContainer.appendChild(errorMessage);
                }
            });

            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;',
                };
                return text.replace(/[&<>"']/g, (m) => map[m]);
            }
        </script>
    </body>
</html>
