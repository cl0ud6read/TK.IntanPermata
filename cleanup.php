<?php
App\Models\FinanceTransaction::where('finance_category_id', 13)->update(['finance_category_id' => 1]);
App\Models\FinanceCategory::where('id', 13)->delete();
echo "Cleaned up duplicate category.\n";
