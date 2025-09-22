<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expense::where('user_id', auth()->id());

        // Apply filters
        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $expenses = $query->orderBy('date', 'desc')->paginate(10)->appends($request->query());

        // Sum for chart (with filters)
        $incomeQuery = Expense::where('user_id', auth()->id())->where('type', 'income');
        $expenseQuery = Expense::where('user_id', auth()->id())->where('type', 'expense');
        
        if ($request->filled('date_from')) {
            $incomeQuery->where('date', '>=', $request->date_from);
            $expenseQuery->where('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $incomeQuery->where('date', '<=', $request->date_to);
            $expenseQuery->where('date', '<=', $request->date_to);
        }
        if ($request->filled('category')) {
            $incomeQuery->where('category_id', $request->category);
            $expenseQuery->where('category_id', $request->category);
        }

        $income = $incomeQuery->sum('amount');
        $expense = $expenseQuery->sum('amount');

        // Get categories for filter dropdown
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('expenses.index', compact('expenses', 'income', 'expense', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // Find or create category
        $categoryName = ucwords(strtolower($request->category));
        $category = Category::firstOrCreate(
            ['user_id' => auth()->id(), 'name' => $categoryName],
            ['user_id' => auth()->id(), 'name' => $categoryName]
        );

        Expense::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'type' => $request->type,
            'category_id' => $category->id,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $expense = Expense::with('category')->where('user_id', auth()->id())->findOrFail($id);
        $expense->category_name = $expense->category->name ?? '';

        return response()->json($expense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // Find or create category
        $categoryName = ucwords(strtolower($request->category));
        $category = Category::firstOrCreate(
            ['user_id' => auth()->id(), 'name' => $categoryName],
            ['user_id' => auth()->id(), 'name' => $categoryName]
        );

        $expense = Expense::where('user_id', auth()->id())->findOrFail($id);

        $expense->update([
            'amount' => $request->amount,
            'type' => $request->type,
            'category_id' => $category->id,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $expense = Expense::where('user_id', auth()->id())->findOrFail($id);
        $expense->delete();
        
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
