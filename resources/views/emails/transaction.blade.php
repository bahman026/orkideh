<!DOCTYPE html>
<html>
<body>
<p>{{ $type === 'decrease' ? __('email.your_account_has_been_debited') : __('email.your_account_has_been_credited') }}</p>
<p>{{ __('email.transaction_id') }}: {{ $transaction->id }}</p>
<p>{{ __('email.amount') }}: {{ $transaction->amount }}</p>
<p>{{ __('email.card_number') }}: {{ $card->card_number }}</p>
<p>{{ __('email.transaction_date') }}: {{ $transaction->created_at->format('Y-m-d H:i:s') }}</p>
</body>
</html>
