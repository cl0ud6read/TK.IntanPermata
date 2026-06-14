<x-app-layout title="Satuan">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('Daftar Satuan') }}
            </h2>
            @if(auth()->user()->role === 'admin')<x-primary-button x-data x-on:click="$dispatch('create-unit')">
                <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                {{ __('Tambah Satuan') }}
            </x-primary-button>@endif
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:units.unit-table />
        </div>
    </div>

    <livewire:units.unit-form />
    <livewire:units.unit-detail />
</x-app-layout>
