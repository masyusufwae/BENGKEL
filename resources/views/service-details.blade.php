@extends('layouts.front')

@section('title', 'Service Details - ' . $service['title'])

@section('styles')
<style>
    /* Override dark body for this specific page's content area */
    .service-content-wrapper {
        background-color: #ffffff;
        color: #333333;
    }
    
    /* Service Details Hero */
    .service-hero {
        position: relative;
        height: 300px;
        background-color: #0b1121; /* Dark background */
        display: flex;
        align-items: center;
        margin-top: -80px; /* Offset the main margin */
        overflow: hidden;
        border-bottom: 4px solid #3b82f6; /* Garis pembatas biru */
        box-shadow: 0 10px 30px rgba(0,0,0,0.15); /* Memperhalus bayangan ke bawah */
    }
    .service-hero-car {
        position: absolute;
        right: -10%;
        top: 50%;
        transform: translateY(-50%);
        height: 250%; /* Dibesarkan signifikan dari yang sebelumnya 150% */
        width: auto;
        opacity: 0.6;
        object-fit: cover;
        mask-image: linear-gradient(to right, transparent, black 40%);
        -webkit-mask-image: linear-gradient(to right, transparent, black 40%);
    }
    .hero-content {
        position: relative;
        z-index: 10;
        padding-top: 60px;
        padding-left: 5%; /* Menyesuaikan agar lurus persis dengan logo navbar */
    }
    
    /* Sidebar List */
    .sidebar-menu-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .sidebar-menu-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.85rem 1.2rem;
        background-color: #ffffff;
        color: #111827;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        border: 1px solid #f3f4f6;
        transition: all 0.2s;
    }
    .sidebar-menu-item:hover, .sidebar-menu-item.active {
        border-color: #3b82f6;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .sidebar-menu-item .badge-count {
        background-color: #f8fafc;
        color: #111827;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: bold;
        border: 1px solid #e2e8f0;
    }
    .sidebar-menu-item:hover .badge-count, .sidebar-menu-item.active .badge-count {
        background-color: #f8fafc;
        color: #3b82f6;
        border-color: #3b82f6;
    }
    
    /* Content Typography */
    .content-area p {
        color: #6b7280;
        line-height: 1.7;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }
    .content-area h3 {
        color: #111827;
        font-size: 1.8rem;
        font-weight: 800;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
    }
    /* The light grey box from the reference */
    .highlight-box {
        background-color: #f8fafc;
        padding: 2.5rem 3rem;
        margin: 2rem 0;
        text-align: center;
    }
    .highlight-box p {
        color: #475569;
        margin: 0;
        font-size: 0.95rem;
    }
    
    /* Newsletter Box matching reference */
    .newsletter-box {
        background-color: #0b1121;
        padding: 2.5rem 2rem;
        border-radius: 6px;
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    .newsletter-box h4 {
        color: #ffffff;
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        margin-top: 0;
    }
    .newsletter-box .subtitle {
        color: #f59e0b; /* Orange/yellow */
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .newsletter-form {
        display: flex;
    }
    .newsletter-form input {
        flex: 1;
        background-color: #1e293b;
        border: none;
        padding: 0.85rem 1rem;
        color: #ffffff;
        font-size: 0.85rem;
        border-radius: 4px 0 0 4px;
        outline: none;
    }
    .newsletter-form input::placeholder {
        color: #94a3b8;
    }
    .newsletter-form button {
        background-color: #3b82f6;
        color: #ffffff;
        border: none;
        padding: 0 1.25rem;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }
    .newsletter-form button:hover {
        background-color: #2563eb;
    }
</style>
@endsection

@section('content')

<!-- Hero Area -->
<section class="service-hero">
    <!-- Abstract right car headlight image -->
    <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Car Headlight" class="service-hero-car">
    
    <div class="w-full hero-content">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2">Services Details</h1>
        <p class="font-bold text-sm tracking-wide">
            <a href="{{ url('/') }}" class="text-white hover:text-blue-400 no-underline">Home</a> 
            <span class="mx-2 text-slate-400">>></span> 
            <span class="text-blue-500">Services Details</span>
        </p>
    </div>
</section>

<!-- Page Content -->
<section class="py-16 service-content-wrapper">
    <div class="container">
        <div class="row">
            <!-- Left Content -->
            <div class="col-lg-8 mb-5 mb-lg-0 pr-lg-5 content-area">
                <img src="{{ $service['main_image'] }}" alt="{{ $service['title'] }}" class="w-full rounded-xl mb-8 object-cover object-center h-[400px]">
                
                <h3>{{ $service['title'] }}</h3>
                <p>{!! nl2br(e($service['description_1'])) !!}</p>
                <p>{!! nl2br(e($service['description_2'])) !!}</p>

                <div class="highlight-box">
                    <p>{{ $service['highlight_text'] }}</p>
                </div>

                <p>{!! nl2br(e($service['description_3'])) !!}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-8">
                    <img src="{{ $service['sub_image_1'] }}" class="w-full h-56 object-cover rounded-xl" alt="Process 1">
                    <img src="{{ $service['sub_image_2'] }}" class="w-full h-56 object-cover rounded-xl" alt="Process 2">
                </div>

                <h3>{{ $service['subtitle'] ?? 'Our Commitment to Quality' }}</h3>
                <p>{!! nl2br(e($service['sub_description'])) !!}</p>
            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4">
                <!-- Services Menu List -->
                <div class="sidebar-menu-list">
                    @foreach($all_services as $slug => $s)
                        <a href="{{ url('/services/' . $slug) }}" class="sidebar-menu-item {{ $slug == $current_slug ? 'active' : '' }}">
                            <span>{{ $s['title'] }}</span>
                            <span class="badge-count">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        </a>
                    @endforeach
                </div>

                <!-- Newsletter Subscribe -->
                <div class="newsletter-box">
                    <div class="subtitle">Subscribe</div>
                    <h4>Get Newsletter</h4>
                    
                    <form class="newsletter-form border border-slate-700 rounded items-stretch">
                        <input type="text" placeholder="Search">
                        <button type="submit">
                            <!-- Search Icon (Using standard SVG to match reference) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Contact/Representative Image -->
                <div class="rounded-xl overflow-hidden mt-4">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Service Advisor" class="w-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Navbar scroll effect -> On a white page background, make sure the navbar stays dark
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar-custom');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
@endsection