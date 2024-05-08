<?php

namespace App\Http\Controllers;

use App\Models\TaxRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalaryTaxCalculator extends Controller
{
    //

    public function index()
    {
        return Inertia::render('User/SalaryCalculator');
    }
    private function calculateTaxAmount($income, $taxRates)
    {
        $taxAmount = 0;

        // Iterate through each tax rate record
        foreach ($taxRates as $taxRate) {
            // Check if income falls within the income range
            if ($income >= $taxRate->min_income && ($taxRate->max_income === null || $income <= $taxRate->max_income)) {
                // Apply tax rate formula to calculate tax amount
                $taxAmount += ($income - $taxRate->min_income) * ($taxRate->rate / 100);

                // Add fixed amount, if applicable
                if ($taxRate->fixed_amount !== null) {
                    $taxAmount += $taxRate->fixed_amount;
                }
            }
        }

        return $taxAmount;
    }
    public function calculate(Request $request)
    {

        $MonthlySalary = $request->input('salary');
        $taxRates = TaxRecord::where('year', 2024)->get();
        $YearlytaxAmount = $this->calculateTaxAmount($MonthlySalary*12, $taxRates);
        $YearlytaxAmount= round($YearlytaxAmount);
        $MonthlytaxAmount= round($YearlytaxAmount/12);

        return response()->json([
            'YearlytaxAmount' => $YearlytaxAmount,
            'MonthlytaxAmount' => $MonthlytaxAmount,
        ]);

    }
}
