<?php

namespace App\DTOs;

class PurchaseItemData
{
    public function __construct(
        public int $bahan_baku_id,
        public int $quantity,
        public int $unit_price,
        public ?int $selling_price,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            bahan_baku_id: (int) $data['bahan_baku_id'],
            quantity: (int) $data['quantity'],
            unit_price: (int) $data['unit_price'],
            selling_price: $data['selling_price'],
        );
    }

    public function toArray(): array
    {
        return [
            'bahan_baku_id' => $this->bahan_baku_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'selling_price' => $this->selling_price,
        ];
    }
}
