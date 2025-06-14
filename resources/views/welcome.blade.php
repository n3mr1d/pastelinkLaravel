<x-html class="main-home" doc="{{ $doc }}" where="{{ $doc }}" css="{{ $css }}">
    
    
    <div class="modern-directory bg-dark text-light min-vh-100">
        <!-- Header -->
        <div class="directory-header py-3 px-4 border-bottom border-secondary sticky-top" style="background-color:#131d25;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column">
                    <h1 class="h4 mb-0 text-white">Hidden Line</h1>
                    <p class="small text-muted mb-0">Discover and Share Links</p>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <div class="stats-badge mb-2">
                        <span class="badge bg-primary me-2">{{ count($links->groupBy('catagory')) }} Categories</span>
                        <span class="badge bg-secondary">{{ $links->count() }} Links</span>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <p class="small text-light mb-0">Share your links with the Hidden Line. Register to start sharing. Found a bug or having issues? Contact us at <a href="mailto:idrift@dnmx.su" class="text-white">idrift@dnmx.su</a>. The share link is really safe and anonymous - don't be scared.</p>
                <div class="alert alert-light small mb-0">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                    <strong style="color:red;">Important Notice:</strong> Broken links will be automatically purged from our database during scheduled maintenance. The next cleanup is scheduled daily at 
                    @php
                        $nextCleanup = now()->addDay()->setTime(1, 0, 0);
                        $formattedDate = $nextCleanup->format('l, F j, Y g:i A');
                    @endphp
                    <span class="text-light">{{ $formattedDate }}</span> (UTC).
                </div>
            </div>
        </div>
        @if(session('message') || $errors->any())
        <div class=" alert-{{ session('status', 'info') }} " role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-2"></i>
                <div class="flex-grow-1">
                    {{ session('message') }}
                    @if($errors->any())
                    <ul class="mb-0 mt-1 small">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="container-fluid p-3">
            <div class="row g-2">
                @if(empty($links->all()))
                <div class="bg-dark text-center text-light ">Data Not found</div>
                @endif
                @foreach([
                    'marketplace' => ['fas fa-store', 'Marketplaces', 'primary', '#0d6efd'],
                    'chat room' => ['fas fa-comments', 'Chat Rooms', 'success', '#198754'],
                    'forums' => ['fas fa-comment-alt', 'Forums', 'info', '#0dcaf0'],
                    'service' => ['fas fa-cogs', 'Services', 'warning', '#ffc107'],
                    'search' => ['fas fa-search', 'Search Engines', 'danger', '#dc3545'],
                    'directory link' => ['fas fa-folder', 'Directories', 'purple', '#6f42c1'],
                    'youtube' => ['fab fa-youtube', 'YouTube', 'danger', '#dc3545'],
                    'uploader' => ['fas fa-upload', 'Uploaders', 'cyan', '#0dcaf0'],
                    'news' => ['fas fa-newspaper', 'News', 'primary', '#0d6efd'],
                    'hosting' => ['fas fa-server', 'Hosting', 'success', '#198754'],
                    'other' => ['fas fa-ellipsis-h', 'Other', 'secondary', '#6c757d']
                ] as $category => $config)
             
                @php $categoryLinks = $links->where('catagory', $category); @endphp
                @if($categoryLinks->count() > 0)
                <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="category-card h-100">
                        <input type="checkbox" id="toggle-{{ $loop->index }}" class="category-toggle" checked>
                        <label for="toggle-{{ $loop->index }}" class="category-header">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="d-flex align-items-center">
                                    <div class="icon-wrapper me-2" style="color: {{ $config[3] }};">
                                        <i class="{{ $config[0] }}"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold category-title">{{ $config[1] }}</h6>
                                        <small class="text-muted">{{ $categoryLinks->count() }} links</small>
                                    </div>
                                </div>
                                <div class="toggle-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </label>
    
                        <!-- Links Container -->
                        <div class="links-container">
                            @foreach($categoryLinks as $link)
                            <a href="{{ $link->link }}" class="link-item" target="_blank" rel="noopener noreferrer">
                                <div class="link-content">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="link-title text-truncate">{{ Str::limit($link->title ?? 'Untitled', 30, '...') }}</div>
                                            <div class="link-url text-truncate">{{ Str::limit(parse_url($link->link, PHP_URL_HOST), 30, '...') }}</div>
                                        </div>
                                        <div class="link-arrow">
                                            <i class="fas fa-external-link-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    
    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --dark-bg: #0f1419;
        --card-bg: #1a1f2e;
        --border-color: #2d3748;
        --text-muted: #718096;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .modern-directory {
        background: var(--dark-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    

    
    .directory-header {
        backdrop-filter: blur(10px);
        background: rgba(26, 31, 46, 0.95);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    
    .stats-badge .badge {
        font-size: 0.7rem;
        padding: 4px 8px;
    }
    
    .category-card {
        background: rgba(26, 31, 46, 0.8);
        border-radius: 10px;
        border: 1px solid var(--border-color);
        transition: var(--transition);
        overflow: hidden;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
  
    /* Pure CSS Toggle System */
    .category-toggle {
        display: none;
    }
    
    .category-header {
        display: block;
        padding: 10px 14px;
        border-bottom: 1px solid var(--border-color);
        cursor: pointer;
        transition: var(--transition);
        user-select: none;
        margin: 0;
        text-decoration: none;
        color: inherit;
    }
    

    
    .category-title {
        font-size: 0.9rem;
        letter-spacing: -0.01em;
    }
    
    .toggle-arrow {
        transition: transform 0.3s ease;
        font-size: 0.8rem;
        color: var(--text-muted);
    }
    
  
    
    .icon-wrapper {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 6px;
        backdrop-filter: blur(5px);
    }
    
    .links-container {
        max-height: 0;
        padding: 10px;
        margin-b
        overflow: hidden;
    }
    
    .category-toggle:checked ~ .links-container {
        max-height: 100%;
    }
    
    .link-item {
        display: block;
        padding: 6px 14px;
        color: inherit;
        text-decoration: none;
        border-bottom: 1px solid rgba(45, 55, 72, 0.3);
        transition: var(--transition);
        position: relative;
    }
    
    .link-item:last-child {
        border-bottom: none;
    }
    
    .link-item:hover {
        background: rgba(255, 255, 255, 0.06);
        color: inherit;
        text-decoration: none;
        transform: translateX(3px);
    }
    
    .link-item:hover .link-arrow {
        opacity: 1;
        transform: translateX(2px);
    }
    
    .link-title {
        font-size: 0.85rem;
        font-weight: 500;
        color: #e2e8f0;
        line-height: 1.2;
    }
    
    .link-url {
        font-size: 0.7rem;
        color: var(--text-muted);
        line-height: 1.2;
        margin-top: 1px;
    }
    
    .link-arrow {
        opacity: 0;
        transition: var(--transition);
        font-size: 0.7rem;
        color: var(--text-muted);
    }
    
    .link-favicon img {
        border-radius: 2px;
        opacity: 0.9;
    }
    
    /* Glassmorphism Enhanced */
    .category-card {
        background: rgba(26, 31, 46, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    /* Animation Delays for Cards */
    .category-card {
        animation: slideInUp 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    
    @keyframes slideInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .category-card:nth-child(1) { animation-delay: 0.1s; }
    .category-card:nth-child(2) { animation-delay: 0.15s; }
    .category-card:nth-child(3) { animation-delay: 0.2s; }
    .category-card:nth-child(4) { animation-delay: 0.25s; }
    .category-card:nth-child(5) { animation-delay: 0.3s; }
    .category-card:nth-child(6) { animation-delay: 0.35s; }
    .category-card:nth-child(7) { animation-delay: 0.4s; }
    .category-card:nth-child(8) { animation-delay: 0.45s; }
    .category-card:nth-child(9) { animation-delay: 0.5s; }
    .category-card:nth-child(10) { animation-delay: 0.55s; }
    .category-card:nth-child(11) { animation-delay: 0.6s; }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem !important;
        }
        
        .directory-header {
            padding: 0.75rem 1rem !important;
        }
        
        .directory-header h1 {
            font-size: 1.1rem !important;
        }
        
        .stats-badge .badge {
            font-size: 0.65rem;
            padding: 3px 6px;
        }
        
        .category-header {
            padding: 8px 12px;
        }
        
        .icon-wrapper {
            width: 24px;
            height: 24px;
            font-size: 0.9rem;
        }
        
        .category-title {
            font-size: 0.8rem;
        }
        
        .link-item {
            padding: 5px 12px;
        }
        
        .link-title {
            font-size: 0.8rem;
        }
        
        .link-url {
            font-size: 0.65rem;
        }
    }
    
    @media (max-width: 576px) {
        .row {
            --bs-gutter-x: 0.5rem;
        }
        
        .directory-header {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start !important;
        }
        
        .stats-badge {
            align-self: flex-end;
        }
    }
    
    /* Custom scrollbar for better UX */
    .links-container::-webkit-scrollbar {
        width: 3px;
    }
    
    .links-container::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .links-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
    }
    
    .links-container::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    
    /* Focus states for accessibility */
    .category-header:focus,
    .link-item:focus {
        outline: 2px solid rgba(102, 126, 234, 0.6);
        outline-offset: -2px;
    }
    

    
    /* Enhanced hover effects */
    .category-card:hover .icon-wrapper {
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.15);
    }
    
    .category-card:hover .category-title {
        color: #f7fafc;
    }
    
    /* Link counter styling */
    .category-header small {
        font-size: 0.7rem;
        opacity: 0.8;
    }
    
    /* Improved spacing */
    .link-content {
        padding: 1px 0;
    }
    
    /* Better visual hierarchy */
    .text-muted {
        color: var(--text-muted) !important;
    }
    
    /* Alert improvements */
    .alert {
        background: rgba(26, 31, 46, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    </style>
    </x-html>