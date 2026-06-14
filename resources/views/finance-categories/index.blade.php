<x-app-layout title="Kategori Keuangan">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('Kategori Keuangan') }}
            </h2>
            @if(auth()->user()->role === 'admin')
            <x-primary-button x-data x-on:click="$dispatch('create-finance-category')">
                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                {{ __('Tambah Kategori') }}
            </x-primary-button>
            @endif
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:finance-categories.finance-category-table />
        </div>
    </div>

    <livewire:finance-categories.finance-category-form />
    <livewire:finance-categories.finance-category-detail />
</x-app-layout>
