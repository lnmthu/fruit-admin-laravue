<?php

namespace App\Repositories\Transaction;

use App\Laravue\Models\Transaction;
use App\Repositories\BaseRepository;
use Illuminate\Support\Str;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    protected $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function create(array $attributes)
    {
        $attributes['order_id'] = $attributes['id'];
        $transaction = $this->model->create($attributes);
        return $transaction;
    }

    // public function cancelTransaction($id)
    // {
    //     return $this->update($id, ['payment_status' => 2]);
    // }

    // public function confirmTransaction($id)
    // {
    //     return $this->update($id, ['payment_status' => 1]);
    // }

    public function chargeCard(array $attributes)
    {
        $stripe = new \Stripe\StripeClient($attributes['stripe_secret']);
        $payment = $stripe->charges->create([
            'amount' => $attributes['amount'] * 100,
            'currency' => 'usd',
            'source' => $attributes['token'],
            'description' => $attributes['description'],
        ]);
        $this->update(['payment_code' => $payment->id, 'payment_status' => Transaction::STATUS_COMPLETED], $attributes['id']);
        return response()->json($payment);
    }
}