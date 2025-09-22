<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Barryvdh\DomPDF\Facade\Pdf;

abstract class Controller
{
    //
    public function downloadPDF()
    {
        $month = now()->format('m');
        $year = now()->format('Y');

        $expenses = Expense::where('user_id', auth()->id())
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $pdf = Pdf::loadView('expenses.report', compact('expenses', 'month', 'year'));

        return $pdf->download("Expense_Report_{$month}_{$year}.pdf");
    }
}
