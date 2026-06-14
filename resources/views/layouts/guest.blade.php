@props(['title' => ''])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}{{ !empty($title) ? ' | ' . $title : '' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <style>
            body {
                background-color: #f8fafc; /* slate-50 */
            }
            .tilt-card {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 1.5rem;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
                transform-style: preserve-3d;
                transition: transform 0.5s ease;
                will-change: transform;
            }
            /* Add an inner container that slightly pops out */
            .tilt-inner {
                transform: translateZ(30px);
            }
        </style>
    </head>
    <body class="font-sans text-foreground antialiased relative">
        <!-- Decorative Background -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-500/10 blur-[100px]"></div>
            <div class="absolute bottom-[0%] -right-[10%] w-[40%] h-[40%] rounded-full bg-purple-500/10 blur-[100px]"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <!-- Logo -->
            <div class="mb-4 flex flex-col items-center">
                <img src="{{ asset('images/logo_circle.png') }}" alt="Logo" class="w-20 h-20 shadow-md rounded-full border-2 border-white mb-3">
                <h2 class="text-xl font-bold text-slate-800">TK. Intan Permata</h2>
            </div>

            <div class="tilt-card w-full sm:max-w-lg px-8 py-12 sm:px-12 text-foreground">
                <div class="tilt-inner max-w-sm mx-auto w-full">
                    {{ $slot }}
                </div>
            </div>
        </div>
        
        @livewireScripts

        <!-- Dynamic 3D Tilt Script -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const card = document.querySelector('.tilt-card');
                
                if (card) {
                    card.addEventListener('mousemove', (e) => {
                        const rect = card.getBoundingClientRect();
                        // Calculate position relative to center of card (-1 to 1)
                        const x = (e.clientX - rect.left) / rect.width - 0.5;
                        const y = (e.clientY - rect.top) / rect.height - 0.5;
                        
                        // Maximum rotation degrees (made subtle to not be 'lebay')
                        const maxRotation = 4;
                        
                        // Calculate rotation angles
                        const rotateY = x * maxRotation * 2; // Left/Right movement
                        const rotateX = -y * maxRotation * 2; // Up/Down movement (inverted)
                        
                        // Apply transformation
                        card.style.transform = `perspective(1000px) scale3d(1.01, 1.01, 1.01) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                        card.style.boxShadow = `${-x * 15}px ${-y * 15 + 15}px 40px -10px rgba(79, 70, 229, 0.15)`;
                        card.style.borderColor = '#c7d2fe';
                    });
                    
                    card.addEventListener('mouseenter', () => {
                        // Remove transition during hover for instant tracking response
                        card.style.transition = 'none';
                    });
                    
                    card.addEventListener('mouseleave', () => {
                        // Reset rotation when mouse leaves
                        card.style.transition = 'all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1)';
                        card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
                        card.style.boxShadow = '0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01)';
                        card.style.borderColor = '#e2e8f0';
                    });
                }
            });
        </script>
    </body>
</html>
