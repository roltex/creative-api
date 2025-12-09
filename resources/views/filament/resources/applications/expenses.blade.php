@php
    $expenseCategories = [
        'labor' => '1. შრომის ანაზღაურება',
        'honorarium' => '2. საპატიო ანაზღაურება',
        'transport' => '3. ტრანსპორტირება',
        'living' => '4. საცხოვრებელი',
        'rent' => '5. ქირა',
        'exhibition' => '6. გამოფენა',
        'printing' => '7. ბეჭდვა',
        'other' => '8. სხვა',
    ];
    
    // Get the record from the component state
    $record = $getRecord();
    $formData = $record->form_data ?? [];
    $expenses = $formData['expenseCategories'] ?? [];
@endphp

<div class="space-y-6">
    @foreach($expenseCategories as $categoryKey => $categoryLabel)
        @php
            $categoryExpenses = $expenses[$categoryKey] ?? [];
        @endphp
        
        @if(!empty($categoryExpenses) && is_array($categoryExpenses))
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <h3 class="font-semibold text-lg mb-4 text-gray-900">{{ $categoryLabel }}</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">დასახელება</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">საზომი ერთეული</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">რაოდენობა</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">ერთეულის ფასი (₾)</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">ჯამი (₾)</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">საქართველოდან (₾)</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">თვითდაფინანსება (₾)</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">სხვა წყარო (₾)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($categoryExpenses as $expense)
                                @php
                                    $quantity = $expense['quantity'] ?? 0;
                                    $unitPrice = $expense['unitPrice'] ?? 0;
                                    $total = $quantity * $unitPrice;
                                @endphp
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $expense['name'] ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $expense['unit'] ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ number_format($quantity, 2) }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ number_format($unitPrice, 2) }} ₾</td>
                                    <td class="px-4 py-2 text-sm font-semibold text-gray-900">{{ number_format($total, 2) }} ₾</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ number_format($expense['creativeGeorgiaAmount'] ?? 0, 2) }} ₾</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ number_format($expense['selfFunding'] ?? 0, 2) }} ₾</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ number_format($expense['otherFunding'] ?? 0, 2) }} ₾</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endforeach
    
    @if(empty($expenses) || collect($expenses)->flatten()->isEmpty())
        <p class="text-gray-500 text-sm">ხარჯები არ არის მითითებული</p>
    @endif
</div>
