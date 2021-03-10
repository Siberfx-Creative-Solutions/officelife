<?php

namespace App\Http\ViewHelpers\Dashboard;

use App\Helpers\DateHelper;
use App\Helpers\MoneyHelper;
use App\Helpers\AvatarHelper;
use App\Models\Company\Company;
use App\Models\Company\Expense;
use Illuminate\Support\Collection;

class DashboardExpenseViewHelper
{
    /**
     * Array containing all the expenses that are waiting for accounting
     * approval in the company.
     *
     * @param Company $company
     * @return Collection|null
     */
    public static function waitingForAccountingApproval(Company $company): ?Collection
    {
        $expenses = $company->expenses()
            ->with('category')
            ->with('employee')
            ->where('status', Expense::AWAITING_ACCOUTING_APPROVAL)
            ->latest()
            ->get();

        $expensesCollection = collect([]);
        foreach ($expenses as $expense) {
            $manager = $expense->managerApprover;

            $expensesCollection->push([
                'id' => $expense->id,
                'title' => $expense->title,
                'amount' => MoneyHelper::format($expense->amount, $expense->currency),
                'status' => $expense->status,
                'category' => ($expense->category) ? $expense->category->name : null,
                'expensed_at' => DateHelper::formatDate($expense->expensed_at),
                'converted_amount' => $expense->converted_amount ?
                    MoneyHelper::format($expense->converted_amount, $expense->converted_to_currency) :
                    null,
                'manager' => $manager ? [
                    'id' => $manager->id,
                    'name' => $manager->name,
                    'avatar' => AvatarHelper::getImage($manager),
                ] : ($expense->manager_approver_name == '' ? null : $expense->manager_approver_name),
                'employee' => $expense->employee ? [
                    'id' => $expense->employee->id,
                    'name' => $expense->employee->name,
                    'avatar' => AvatarHelper::getImage($expense->employee),
                ] : [
                    'employee_name' => $expense->employee_name,
                ],
                'url' => route('dashboard.expenses.show', [
                    'company' => $company,
                    'expense' => $expense->id,
                ]),
            ]);
        }

        return $expensesCollection;
    }

    /**
     * Array containing all the expenses that are waiting for manager
     * approval in the company.
     *
     * @param Company $company
     * @return Collection|null
     */
    public static function waitingForManagerApproval(Company $company): ?Collection
    {
        $expenses = $company->expenses()
            ->with('category')
            ->with('employee')
            ->with('employee.managers')
            ->where('status', Expense::AWAITING_MANAGER_APPROVAL)
            ->latest()
            ->get();

        $expensesCollection = collect([]);
        foreach ($expenses as $expense) {
            $managerCollection = collect([]);

            if ($expense->employee) {
                foreach ($expense->employee->managers as $manager) {
                    $managerCollection->push([
                        'id' => $manager->manager->id,
                        'name' => $manager->manager->name,
                        'avatar' => AvatarHelper::getImage($manager->manager),
                    ]);
                }
            }

            $expensesCollection->push([
                'id' => $expense->id,
                'title' => $expense->title,
                'amount' => MoneyHelper::format($expense->amount, $expense->currency),
                'status' => $expense->status,
                'category' => ($expense->category) ? $expense->category->name : null,
                'expensed_at' => DateHelper::formatDate($expense->expensed_at),
                'converted_amount' => $expense->converted_amount ?
                    MoneyHelper::format($expense->converted_amount, $expense->converted_to_currency) :
                    null,
                'managers' => $managerCollection->count() == 0 ? null : $managerCollection,
                'employee' => ($expense->employee) ? [
                    'id' => $expense->employee->id,
                    'name' => $expense->employee->name,
                    'avatar' => AvatarHelper::getImage($expense->employee),
                ] : [
                    'employee_name' => $expense->employee_name,
                ],
                'url' => route('dashboard.expenses.show', [
                    'company' => $company,
                    'expense' => $expense->id,
                ]),
            ]);
        }

        return $expensesCollection;
    }

    /**
     * Array containing all the expenses that have been either accepted or
     * rejected.
     *
     * @param Company $company
     * @return Collection|null
     */
    public static function acceptedAndRejected(Company $company): ?Collection
    {
        $expenses = $company->expenses()
            ->with('category')
            ->with('employee')
            ->with('employee.managers')
            ->where('status', Expense::ACCEPTED)
            ->orWhere('status', Expense::REJECTED_BY_ACCOUNTING)
            ->orWhere('status', Expense::REJECTED_BY_MANAGER)
            ->orderBy('expenses.updated_at', 'asc')
            ->get();

        $expensesCollection = collect([]);
        foreach ($expenses as $expense) {
            $expensesCollection->push([
                'id' => $expense->id,
                'title' => $expense->title,
                'amount' => MoneyHelper::format($expense->amount, $expense->currency),
                'status' => $expense->status,
                'category' => ($expense->category) ? $expense->category->name : null,
                'expensed_at' => DateHelper::formatDate($expense->expensed_at),
                'converted_amount' => $expense->converted_amount ?
                    MoneyHelper::format($expense->converted_amount, $expense->converted_to_currency) :
                    null,
                'employee' => ($expense->employee) ? [
                    'id' => $expense->employee->id,
                    'name' => $expense->employee->name,
                    'avatar' => AvatarHelper::getImage($expense->employee),
                ] : [
                    'employee_name' => $expense->employee_name,
                ],
                'url' => route('dashboard.expenses.summary', [
                    'company' => $company,
                    'expense' => $expense->id,
                ]),
            ]);
        }

        return $expensesCollection;
    }

    /**
     * Array containing information about the given expense.
     *
     * @param Expense $expense
     * @return array
     */
    public static function expense(Expense $expense): array
    {
        $manager = $expense->managerApprover;
        $accountant = $expense->accountingApprover;
        $employee = $expense->employee;

        $expense = [
            'id' => $expense->id,
            'title' => $expense->title,
            'created_at' => DateHelper::formatDate($expense->created_at),
            'amount' => MoneyHelper::format($expense->amount, $expense->currency),
            'status' => $expense->status,
            'category' => ($expense->category) ? $expense->category->name : null,
            'expensed_at' => DateHelper::formatDate($expense->expensed_at),
            'converted_amount' => $expense->converted_amount ?
                MoneyHelper::format($expense->converted_amount, $expense->converted_to_currency) :
                null,
            'converted_at' => $expense->converted_at ?
                DateHelper::formatShortDateWithTime($expense->converted_at) :
                null,
            'exchange_rate' => $expense->exchange_rate,
            'exchange_rate_explanation' => '1 '.$expense->converted_to_currency.' = '.$expense->exchange_rate.' '.$expense->currency,
            'manager' => $manager ? [
                'id' => $manager->id,
                'name' => $manager->name,
                'avatar' => AvatarHelper::getImage($manager),
                'position' => $manager->position ? $manager->position->title : null,
                'status' => $manager->status ? $manager->status->name : null,
            ] : [
                'name' => $expense->manager_approver_name,
            ],
            'manager_approver_approved_at' => $expense->manager_approver_approved_at ?
                DateHelper::formatDate($expense->manager_approver_approved_at) :
                null,
            'manager_rejection_explanation' => $expense->manager_rejection_explanation,
            'accountant' => $accountant ? [
                'id' => $accountant->id,
                'name' => $accountant->name,
                'avatar' => AvatarHelper::getImage($accountant),
                'position' => $accountant->position ? $accountant->position->title : null,
                'status' => $accountant->status ? $accountant->status->name : null,
            ] : [
                'name' => $expense->accounting_approver_name,
            ],
            'accounting_approver_approved_at' => ($expense->accounting_approver_approved_at) ?
                DateHelper::formatDate($expense->accounting_approver_approved_at) :
                null,
            'accounting_rejection_explanation' => $expense->accounting_rejection_explanation,
            'employee' => $employee ? [
                'id' => $employee->id,
                'name' => $employee->name,
                'avatar' => AvatarHelper::getImage($employee),
                'position' => $employee->position ? $employee->position->title : null,
                'status' => $employee->status ? $employee->status->name : null,
            ] : [
                'employee_name' => $expense->employee_name,
            ],
        ];

        return $expense;
    }
}
