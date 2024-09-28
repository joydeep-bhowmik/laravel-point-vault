<?php

namespace JoydeepBhowmik\LaravelPointVault\Traits;

use JoydeepBhowmik\LaravelPointVault\Models\Point;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasPoints
{
    /**
     * Get the current balance for the model.
     *
     * @return int
     */
    public function getCurrentBalance(): int
    {
        $creditSum = $this->points()->where('transaction_type', 'CREDIT')->sum('amount');
        $debitSum = $this->points()->where('transaction_type', 'DEBIT')->sum('amount');

        return $creditSum - $debitSum;
    }

    /**
     * Debit a specified amount from the model's balance.
     *
     * @param int $amount
     * @param string|null $note
     * @return void
     * @throws \Exception
     */
    public function debit(int $amount, string $note = null): void
    {
        $this->makeTransaction($amount, 'DEBIT', $note);
    }

    /**
     * Credit a specified amount to the model's balance.
     *
     * @param int $amount
     * @param string|null $note
     * @return void
     */
    public function credit(int $amount, string $note = null): void
    {
        $this->makeTransaction($amount, 'CREDIT', $note);
    }

    /**
     * Define a polymorphic relationship to the points table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function points(): MorphMany
    {
        return $this->morphMany(Point::class, 'pointable');
    }

    /**
     * Create a new point transaction.
     *
     * @param int $amount
     * @param string $type
     * @param string|null $note
     * @return void
     * @throws \Exception
     */
    protected function makeTransaction(int $amount, string $type, string $note = null): void
    {
        if (!in_array($type, ['CREDIT', 'DEBIT'])) {
            throw new \Exception("Invalid transaction type. It must be either 'CREDIT' or 'DEBIT'.");
        }

        if ($amount <= 0) {
            throw new \Exception("The amount must be positive.");
        }

        if ($type === 'DEBIT' && $amount > $this->getCurrentBalance()) {
            throw new \Exception("Insufficient balance to debit the specified amount.");
        }

        $this->points()->create([
            'amount' => $amount,
            'transaction_type' => $type,
            'note' => $note,
        ]);
    }
}
