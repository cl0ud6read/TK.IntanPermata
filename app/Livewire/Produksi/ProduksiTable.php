<?php

namespace App\Livewire\Produksi;

use App\Models\Produksi;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;

final class ProduksiTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'produksi-table';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::exportable('laporan_produksi_' . now()->format('Y_m_d'))
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),

            PowerGrid::header()
                ->showSearchInput(),

            PowerGrid::footer()
                ->showPerPage(perPage: 10, perPageValues: [10, 25, 50, 100])
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Produksi::query()
            ->with(['product', 'creator']);
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('production_number')
            ->add('product_name', fn(Produksi $model) => $model->product ? $model->product->name : '-')
            ->add('target_quantity')
            ->add('status_label', function(Produksi $model) {
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'in_progress' => 'bg-blue-100 text-blue-800',
                    'completed' => 'bg-green-100 text-green-800',
                    'failed' => 'bg-red-100 text-red-800',
                ];
                $color = $statusColors[$model->status] ?? 'bg-gray-100 text-gray-800';
                return '<span class="px-2 py-1 text-xs font-medium rounded ' . $color . '">' . strtoupper($model->status) . '</span>';
            })
            ->add('status_export', fn(Produksi $model) => strtoupper($model->status))
            ->add('start_date_formatted', fn(Produksi $model) => $model->start_date ? $model->start_date->format('d/m/Y') : '-')
            ->add('created_at_formatted', fn(Produksi $model) => $model->created_at->format('d/m/Y'));
    }

    public function columns(): array
    {
        return [
            Column::action('Aksi'),

            Column::make('Nomor Produksi', 'production_number')
                ->sortable()
                ->searchable(),

            Column::make('Produk', 'product_name', 'product_id')
                ->sortable()
                ->searchable(),

            Column::make('Target Qty', 'target_quantity')
                ->sortable()
                ->bodyAttribute('text-center'),

            Column::make('Status', 'status_label', 'status')
                ->sortable()
                ->headerAttribute('text-center')
                ->bodyAttribute('text-center')
                ->visibleInExport(false),

            Column::make('Status', 'status_export', 'status')
                ->hidden()
                ->visibleInExport(true),

            Column::make('Tgl Mulai', 'start_date_formatted', 'start_date')
                ->sortable(),

            Column::make('Dibuat Pada', 'created_at_formatted', 'created_at')
                ->hidden()
                ->visibleInExport(true),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::multiSelect('status_label', 'status')
                ->dataSource(collect([
                    ['value' => 'pending', 'text' => 'PENDING'],
                    ['value' => 'in_progress', 'text' => 'IN PROGRESS'],
                    ['value' => 'completed', 'text' => 'COMPLETED'],
                    ['value' => 'failed', 'text' => 'FAILED'],
                ]))
                ->optionValue('value')
                ->optionLabel('text'),
                
            Filter::datepicker('start_date_formatted', 'start_date')
                ->params([
                    'enableTime' => false,
                    'dateFormat' => 'Y-m-d',
                    'altInput' => true,
                    'altFormat' => 'd/m/Y',
                ]),
        ];
    }

    public function actions(Produksi $row): array
    {
        $actions = [
            Button::add('view')
                ->slot('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>')
                ->class('bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-md flex items-center justify-center')
                ->route('produksi.show', ['produksi' => $row->id])
                ->tooltip('Lihat Detail'),
        ];

        return $actions;
    }
}
