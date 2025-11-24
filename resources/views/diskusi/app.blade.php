<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Community Discussion - ' . config('app.name'))</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        .discussion-navbar {
            background: linear-gradient(135deg, #28a745 0%, #208030 100%);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 1rem 0;
        }
        
        .discussion-navbar .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .discussion-navbar .nav-link {
            font-weight: 500;
            margin: 0 5px;
            padding: 10px 15px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        
        .discussion-navbar .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }
        
        .discussion-navbar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .navbar-toggler {
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .sidebar {
            background: #fff;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            min-height: calc(100vh - 56px);
            position: sticky;
            top: 56px;
        }
        
        .sidebar .nav-link {
            color: #495057;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #28a745 0%, #208030 100%);
            color: #fff;
        }
        
        .main-content {
            min-height: calc(100vh - 56px);
        }
        
        .discussion-card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        
        .discussion-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .btn-discussion {
            background: linear-gradient(135deg, #28a745 0%, #208030 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
        }
        
        .btn-discussion:hover {
            background: linear-gradient(135deg, #208030 0%, #28a745 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .topic-item {
            border-left: 3px solid #28a745;
            transition: all 0.3s ease;
        }
        
        .topic-item:hover {
            background-color: rgba(40, 167, 69, 0.05);
        }
        
        .comment-item {
            border-left: 2px solid #dee2e6;
            margin-left: 20px;
        }
        
        .resolved-badge {
            background-color: #28a745;
        }
        
        .unresolved-badge {
            background-color: #ffc107;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .user-avatar-lg {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }
        
        .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, #28a745 0%, #208030 100%);
            color: white !important;
        }
        
        .dropdown-divider {
            margin: 0.5rem 0;
        }
        
        .greeting-text {
            font-weight: 500;
            margin-right: 5px;
        }
        
        /* Floating AI Button */
        .floating-ai-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745 0%, #208030 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .floating-ai-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        
        /* AI Modal */
        .ai-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }
        
        .ai-modal-content {
            background-color: white;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
        }
        
        .ai-modal-header {
            background: linear-gradient(135deg, #28a745 0%, #208030 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .ai-modal-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .ai-modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }
        
        /* Chat Container */
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .chat-history {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 15px;
            max-height: 400px;
        }
        
        .chat-message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            max-width: 80%;
        }
        
        .user-message {
            background-color: #d1ecf1;
            margin-left: auto;
            text-align: right;
        }
        
        .ai-message {
            background-color: #e2e3e5;
            margin-right: auto;
        }
        
        .message-content {
            word-wrap: break-word;
        }
        
        .message-time {
            font-size: 0.7rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .ai-input-group {
            display: flex;
        }
        
        .ai-input-group input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px 0 0 8px;
            outline: none;
        }
        
        .ai-input-group button {
            background: linear-gradient(135deg, #28a745 0%, #208030 100%);
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
        }
        
        .ai-loading {
            display: none;
            text-align: center;
            padding: 15px;
        }
        
        .ai-loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #28a745;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Discussion Navbar -->
    <nav class="navbar navbar-expand-lg discussion-navbar navbar-dark py-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('diskusi.index') }}">
                <i class="fas fa-comments me-2"></i>{{ config('app.name') }} Community
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#discussionNavbar" aria-controls="discussionNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="discussionNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('diskusi.index') ? 'active' : '' }}" href="{{ route('diskusi.index') }}">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('diskusi.create') ? 'active' : '' }}" href="{{ route('diskusi.create') }}">
                            <i class="fas fa-plus-circle me-1"></i> New Topic
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="greeting-text">Hai, {{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down ms-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    @if(Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="user-avatar-lg me-2">
                                    @else
                                        <i class="fas fa-user-circle me-2 fa-2x text-muted"></i>
                                    @endif
                                    <div class="d-inline-block">
                                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('account.settings') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Discussion Sidebar -->
            <div class="col-lg-2 d-none d-lg-block p-0">
                @include('layouts.shared.sidebar')
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-10 col-12 p-0">
                <div class="main-content p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <!-- DEBUG: Current route name: {{ Route::currentRouteName() }} -->
    
    <!-- Floating AI Button -->
    @if(Route::currentRouteName() === 'diskusi.show')
        <button class="floating-ai-btn" id="floatingAiBtn" title="Ask AI">
            <i class="fas fa-robot"></i>
        </button>
        
        <!-- AI Modal -->
        <div class="ai-modal" id="aiModal">
            <div class="ai-modal-content">
                <div class="ai-modal-header">
                    <h5><i class="fas fa-robot me-2"></i>AI Assistant</h5>
                    <button type="button" class="btn-close btn-close-white" id="closeAiModal"></button>
                </div>
                <div class="ai-modal-body">
                    <div class="chat-container">
                        <div class="chat-history" id="aiChatHistory">
                            <!-- Chat messages will be added here -->
                        </div>
                        <div class="ai-loading" id="aiLoading">
                            <div class="ai-loading-spinner"></div>
                            <p class="mt-2">AI is thinking...</p>
                        </div>
                    </div>
                    <div class="ai-input-group mt-3">
                        <input type="text" id="aiQuestionInput" placeholder="Ask something about this discussion...">
                        <button id="askAiButton"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
                <div class="ai-modal-footer">
                    <button type="button" class="btn btn-secondary" id="clearChatBtn">Clear Chat</button>
                    <button type="button" class="btn btn-secondary" id="closeAiModalFooter">Close</button>
                </div>
            </div>
        </div>
    @endif
    
    @yield('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Floating AI button functionality
            const floatingAiBtn = document.getElementById('floatingAiBtn');
            const aiModal = document.getElementById('aiModal');
            const closeAiModal = document.getElementById('closeAiModal');
            const closeAiModalFooter = document.getElementById('closeAiModalFooter');
            const askAiButton = document.getElementById('askAiButton');
            const aiQuestionInput = document.getElementById('aiQuestionInput');
            const aiLoading = document.getElementById('aiLoading');
            const aiChatHistory = document.getElementById('aiChatHistory');
            
            // Chat history array
            let chatHistory = [];
            
            // Function to add message to chat
            function addMessageToChat(sender, message) {
                chatHistory.push({sender, message, timestamp: new Date()});
                
                // Create message element
                const messageElement = document.createElement('div');
                messageElement.className = `chat-message ${sender === 'user' ? 'user-message' : 'ai-message'}`;
                
                const messageContent = document.createElement('div');
                messageContent.className = 'message-content';
                messageContent.innerHTML = message;
                
                const messageTime = document.createElement('div');
                messageTime.className = 'message-time';
                messageTime.textContent = new Date().toLocaleTimeString();
                
                messageElement.appendChild(messageContent);
                messageElement.appendChild(messageTime);
                
                if (aiChatHistory) {
                    aiChatHistory.appendChild(messageElement);
                    aiChatHistory.scrollTop = aiChatHistory.scrollHeight;
                }
            }
            
            // Function to clear chat
            function clearChat() {
                chatHistory = [];
                if (aiChatHistory) {
                    aiChatHistory.innerHTML = '';
                }
            }
            
            if (floatingAiBtn) {
                floatingAiBtn.addEventListener('click', function() {
                    aiModal.style.display = 'flex';
                    // Don't clear chat when opening from floating button
                });
            }
            
            if (closeAiModal) {
                closeAiModal.addEventListener('click', function() {
                    aiModal.style.display = 'none';
                });
            }
            
            if (closeAiModalFooter) {
                closeAiModalFooter.addEventListener('click', function() {
                    aiModal.style.display = 'none';
                });
            }
            
            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === aiModal) {
                    aiModal.style.display = 'none';
                }
            });
            
            // Handle Enter key in input
            if (aiQuestionInput) {
                aiQuestionInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        askAiButton.click();
                    }
                });
            }
            
            // Clear chat functionality
            const clearChatBtn = document.getElementById('clearChatBtn');
            if (clearChatBtn) {
                clearChatBtn.addEventListener('click', function() {
                    clearChat();
                });
            }
            
            // Ask AI functionality
            if (askAiButton) {
                askAiButton.addEventListener('click', function() {
                    const question = aiQuestionInput.value.trim();
                    if (!question) {
                        alert('Please enter a question');
                        return;
                    }
                    
                    // Add user question to chat
                    addMessageToChat('user', question);
                    
                    // Clear input
                    aiQuestionInput.value = '';
                    
                    // Show loading
                    aiLoading.style.display = 'block';
                    
                    // Get context from the current discussion (only if on a discussion page)
                    let context = '';
                    if (window.location.href.includes('/diskusi/')) {
                        const contextElements = document.querySelectorAll('.discussion-content, .comment-item');
                        
                        // Extract content from discussion and comments
                        contextElements.forEach(element => {
                            context += element.innerText + '\n\n';
                        });
                        
                        // Limit context size
                        if (context.length > 5000) {
                            context = context.substring(0, 5000);
                        }
                    }
                    
                    // Send request to AI
                    fetch("{{ route('diskusi.ask.ai') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            question: question,
                            context: context
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        aiLoading.style.display = 'none';
                        
                        if (data.success) {
                            // Add AI response to chat
                            addMessageToChat('ai', data.answer);
                        } else {
                            // Add error message to chat with more details
                            let errorMessage = data.error || 'Failed to get response from AI';
                            addMessageToChat('ai', `<span class="text-danger">Error: ${errorMessage}</span>`);
                        }
                    })
                    .catch(error => {
                        aiLoading.style.display = 'none';
                        // Add error message to chat
                        let errorMessage = 'An error occurred while processing your request.';
                        if (error.message) {
                            errorMessage = error.message;
                        } else if (typeof error === 'string') {
                            errorMessage = error;
                        }
                        addMessageToChat('ai', `<span class="text-danger">Error: ${errorMessage}</span>`);
                    });
                });
            }
        });
    </script>
</body>
</html>