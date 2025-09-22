<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Expense Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Add Expense Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Add New Expense</h3>
                    
                    <form method="POST" action="{{ route('expenses.store') }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="amount" :value="__('Amount')" />
                                <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                            </div>
                            
                            <div>
                                <x-input-label for="type" :value="__('Type')" />
                                <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    <option value="">Select Type</option>
                                    <option value="expense">Expense</option>
                                    <option value="income">Income</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('type')" />
                            </div>
                            
                            <div>
                                <x-input-label for="category" :value="__('Category')" />
                                <x-text-input id="category" name="category" type="text" class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('category')" />
                            </div>
                            
                            <div>
                                <x-input-label for="date" :value="__('Date')" />
                                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                                <x-input-error class="mt-2" :messages="$errors->get('date')" />
                            </div>
                        </div>
                        
                        <div>
                            <x-input-label for="description" :value="__('Description (Optional)')" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                        </div>
                        
                        <div class="flex justify-end">
                            <x-primary-button>{{ __('Add Expense') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-green-50 dark:bg-green-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">+</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-green-600 dark:text-green-400">Total Income</p>
                                <p class="text-2xl font-bold text-green-900 dark:text-green-100">${{ number_format($income, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-red-50 dark:bg-red-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">-</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-red-600 dark:text-red-400">Total Expenses</p>
                                <p class="text-2xl font-bold text-red-900 dark:text-red-100">${{ number_format($expense, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-blue-50 dark:bg-blue-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">=</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Balance</p>
                                <p class="text-2xl font-bold {{ ($income - $expense) >= 0 ? 'text-green-900 dark:text-green-100' : 'text-red-900 dark:text-red-100' }}">
                                    ${{ number_format($income - $expense, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Filter Expenses</h3>
                    <form method="GET" action="{{ route('expenses.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="date_from" :value="__('From Date')" />
                            <x-text-input id="date_from" name="date_from" type="date" class="mt-1 block w-full" value="{{ request('date_from') }}" />
                        </div>
                        <div>
                            <x-input-label for="date_to" :value="__('To Date')" />
                            <x-text-input id="date_to" name="date_to" type="date" class="mt-1 block w-full" value="{{ request('date_to') }}" />
                        </div>
                        <div>
                            <x-input-label for="category" :value="__('Category')" />
                            <select id="category" name="category" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end space-x-2">
                            <x-primary-button type="submit">Filter</x-primary-button>
                            <a href="{{ route('expenses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Expenses -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Expenses</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($expenses as $expense)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ date('M d, Y', strtotime($expense->date)) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $expense->category->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $expense->type === 'income' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                            {{ ucfirst($expense->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium
                                        {{ $expense->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        ${{ number_format($expense->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <button onclick="editExpense({{ $expense->id }})" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                                            Edit
                                        </button>
                                        <button onclick="confirmDelete({{ $expense->id }}, '{{ $expense->category->name ?? 'N/A' }}', {{ $expense->amount }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No expenses found. Add your first expense above!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($expenses->hasPages())
                    <div class="mt-4">
                        {{ $expenses->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-4">Delete Expense</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Are you sure you want to delete this expense?
                    </p>
                    <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100" id="deleteExpenseDetails"></p>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                        This action cannot be undone.
                    </p>
                </div>
                <div class="flex justify-center space-x-3 mt-4">
                    <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Edit Expense</h3>
                <form id="editForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="edit_amount" :value="__('Amount')" />
                        <x-text-input id="edit_amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="edit_type" :value="__('Type')" />
                        <select id="edit_type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                            <option value="expense">Expense</option>
                            <option value="income">Income</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="edit_category" :value="__('Category')" />
                        <x-text-input id="edit_category" name="category" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="edit_date" :value="__('Date')" />
                        <x-text-input id="edit_date" name="date" type="date" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="edit_description" :value="__('Description')" />
                        <textarea id="edit_description" name="description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <x-primary-button>{{ __('Update') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editExpense(id) {
            fetch(`/expenses/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_amount').value = data.amount;
                    document.getElementById('edit_type').value = data.type;
                    document.getElementById('edit_category').value = data.category_name;
                    // Format date for HTML date input (YYYY-MM-DD)
                    const date = new Date(data.date);
                    const formattedDate = date.toISOString().split('T')[0];
                    document.getElementById('edit_date').value = formattedDate;
                    document.getElementById('edit_description').value = data.description || '';
                    document.getElementById('editForm').action = `/expenses/${id}`;
                    document.getElementById('editModal').classList.remove('hidden');
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmDelete(id, category, amount) {
            document.getElementById('deleteExpenseDetails').innerHTML = `
                <span class="font-semibold">${category}</span><br>
                <span class="text-lg font-bold text-red-600 dark:text-red-400">$${parseFloat(amount).toFixed(2)}</span>
            `;
            document.getElementById('deleteForm').action = `/expenses/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</x-app-layout>