@extends('layouts.dashboard-admin')

@section('title', 'Greeting Card')

@push('styles')

<style>
/* Reset CSS */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.greeting-card {
    background: rgba(255, 255, 255, 0.95);
    padding: 2rem 3rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 500px;
    width: 90%;
}

.welcome-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #764ba2;
}

.greeting-title {
    color: #2d3748;
    font-size: 2rem;
    margin-bottom: 1rem;
}

.greeting-text {
    color: #4a5568;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.time-date {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}

.admin-info {
    background: #f7fafc;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.admin-name {
    color: #4a5568;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.admin-role {
    color: #718096;
    font-size: 0.9rem;
}

.start-button {
    background: #667eea;
    color: white;
    padding: 0.8rem 2rem;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.start-button:hover {
    background: #764ba2;
}

/* Animasi sederhana */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.greeting-card {
    animation: fadeIn 0.8s ease-out;
} 
</style>
    
@endpush

@section('content')
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="greeting-card">
        <div class="welcome-icon">👋</div>
        <h1 class="greeting-title">Welcome Back, {{ ucfirst(Auth::user()->getRoleNames()->first() ?? 'User') }}!</h1>
        <div class="time-date">
            <span id="current-time"></span>
        </div>
        <p class="greeting-text">
            Selamat datang di dashboard Anda. Kami senang melihat Anda kembali. Semua sistem berjalan dengan lancar, dan sistem Anda sudah terupdate.
        </p>
        <div class="admin-info">
            <div class="admin-name">{{ Auth::user()->name }}</div>

            <div class="admin-role">
                {{ ucfirst(Auth::user()->getRoleNames()->first() ?? 'User') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Menampilkan waktu dan tanggal
    function updateDateTime() {
        const now = new Date();
        const timeDate = now.toLocaleDateString('id', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        document.getElementById('current-time').textContent = timeDate;
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>
@endpush