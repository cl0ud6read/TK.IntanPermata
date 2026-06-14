<x-app-layout title="Penjualan">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('Daftar Penjualan') }}
            </h2>
            @if(auth()->user()->role === 'admin')
            <x-primary-button
                x-data
                x-on:click="window.location.href = '{{ route('sales.create') }}'"
            >
                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                {{ __('Buat Penjualan') }}
            </x-primary-button>
            @endif
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:sales.sales-table />
        </div>
    </div>

    <livewire:components.delete-modal />
</x-app-layout>
