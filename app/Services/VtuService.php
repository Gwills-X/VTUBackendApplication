<?php

namespace App\Services;

// Transaction model – used to record every VTU action (airtime/data)
use App\Models\Transaction;

// Laravel HTTP client – used to call the VTU provider API
use Illuminate\Support\Facades\Http;

// DB facade – used to control database transactions (commit/rollback)
use Illuminate\Support\Facades\DB;

class VtuService
{
    /*
    |--------------------------------------------------------------------------
    | BUY AIRTIME
    |--------------------------------------------------------------------------
    | This method is called when a user wants to buy airtime.
    | It simply passes everything to the main process() method.
    |
    | $user      → The authenticated user
    | $amount    → Airtime amount
    | $number    → Phone number receiving airtime
    | $networkId → Network provider ID (MTN, GLO, etc)
    */
    public function buyAirtime($user, $amount, $number, $networkId)
    {
        return $this->process(
            $user,
            'buy_airtime',   // transaction type
            $amount,
            $number,
            null,            // no plan for airtime
            $networkId
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BUY DATA
    |--------------------------------------------------------------------------
    | This method is called when a user buys a data plan.
    | Instead of amount, we use $plan->price.
    |
    | $plan contains:
    | - plan_id
    | - plan_name
    | - network_id
    | - price
    */
    public function buyData($user, $plan, $number)
    {
        return $this->process(
            $user,
            'buy_data',
            $plan->price,   // price comes from the plan
            $number,
            $plan           // pass full plan object
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MAIN PROCESS METHOD
    |--------------------------------------------------------------------------
    | This handles BOTH airtime and data.
    | Everything flows through here.
    */
    private function process($user, $type, $amount, $number, $plan = null, $networkId = null)
    {
        // Get the user’s wallet relationship
        $wallet = $user->wallet;

        // If wallet does not exist, stop execution
        if (!$wallet) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                "message" => "Invalid user wallet",
            ]);
        }
if($amount < 0){
    throw \Illuminate\Validation\ValidationException::withMessages([
                "amount" => "Amount Cannot be negative",
            ]);
};
        // ---------------------------------------------------
        // CHECK IF USER HAS ENOUGH MONEY
        // ---------------------------------------------------
        if ($wallet->balance < $amount) {

            // Stop immediately if insufficient funds
            return [
                'status' => false,
                'message' => 'Insufficient balance',
                'balance' => $wallet->balance
            ];
        }

        try {

            // ---------------------------------------------------
            // START DATABASE TRANSACTION
            // ---------------------------------------------------
            // This ensures:
            // - If anything fails, everything rolls back
            // - No partial wallet deductions
            DB::beginTransaction();

            // Generate a unique transaction reference
            // Example: BUY_DATA-65f8e21c9f3a2
            $reference = strtoupper($type) . '-' . uniqid();

            // ---------------------------------------------------
            // CREATE TRANSACTION FIRST (PENDING)
            // ---------------------------------------------------
            // We create transaction BEFORE calling API.
            // Status starts as "pending".
            $transaction = Transaction::create([
                'user_id'   => $user->id,
                'type'      => $type,
                'amount'    => $amount,
                'status'    => 'pending',
                'reference' => $reference,
                "phone_number"=>$number,

                // meta column stores extra info as JSON
                'meta'      => json_encode([
                    'phone' => $number,
                    'plan_id' => $plan?->plan_id,
                    'plan_name' => $plan?->plan_name,
                    'network_id' => $networkId ?? $plan?->network_id
                ])
            ]);

            // ---------------------------------------------------
            // PREPARE API PAYLOAD
            // ---------------------------------------------------
            $payload = [
                'mobile_number' => $number,
            ];

            if ($type === 'buy_data') {

                // For data purchase
                $payload['network'] = $plan->network_id;
                $payload['plan']    = $plan->plan_id;
                $payload['url']     = "data";

            } else {

                // For airtime purchase
                $payload['amount']  = $amount;
                $payload['network'] = $networkId;
                $payload['url']     = "topup";
            }

            // ---------------------------------------------------
            // CALL VTU PROVIDER API
            // ---------------------------------------------------
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . config('services.vtu.key'),
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json'
            ])->post(
                config('services.vtu.purchase_url') . $payload['url'],
                $payload
            );

            // Convert API response to array
            $body = $response->json();

            // ---------------------------------------------------
            // CHECK IF API CALL FAILED (SERVER ERROR)
            // ---------------------------------------------------
            if (!$response->successful()) {

                // If API didn’t respond properly,
                // mark transaction as failed
                $transaction->update(['status' => 'failed']);

                DB::commit(); // save failure

                return [
                    'status' => false,
                    'message' => 'VTU API connection failed',
                    'provider_response' => $body,
                    'balance' => $wallet->fresh()->balance
                ];
            }

            // ---------------------------------------------------
            // CHECK PROVIDER RESPONSE STATUS
            // ---------------------------------------------------
            // Some providers use:
            // - status
            // - Status
            $providerStatus = strtolower(
                $body['status'] ?? $body['Status'] ?? ''
            );

            // ---------------------------------------------------
            // IF SUCCESS
            // ---------------------------------------------------
            if ($providerStatus === 'success' || $providerStatus === 'successful') {

                // Deduct money ONLY after confirmed success
                $wallet->decrement('balance', $amount);

                // Update transaction status
                $transaction->update(['status' => 'success']);

            }
            // ---------------------------------------------------
            // IF PENDING
            // ---------------------------------------------------
            elseif ($providerStatus === 'pending') {

                // Do NOT deduct yet
                $transaction->update(['status' => 'pending']);

            }
            // ---------------------------------------------------
            // IF FAILED
            // ---------------------------------------------------
            else {

                // Mark transaction failed
                $transaction->update(['status' => 'failed']);
            }

            // Save all DB changes
            DB::commit();

            return [
                'status' => true,
                'transaction' => $transaction,
                'provider_response' => $body,
                'balance' => $wallet->fresh()->balance
            ];

        } catch (\Exception $e) {

            // ---------------------------------------------------
            // IF ANY ERROR OCCURS
            // ---------------------------------------------------
            DB::rollBack(); // undo everything

            return [
                'status' => false,
                'message' => $e->getMessage(),
                'balance' => $wallet?->fresh()->balance ?? 0
            ];
        }
    }

public function buyElectricity($user, $data)
{
    return $this->processElectricity($user, $data);
}


    private function processElectricity($user, $data)
{
    $wallet = $user->wallet;

    if (!$wallet) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            "message" => "Invalid user wallet",
        ]);
    }

    $amount = $data['amount'];

    if ($wallet->balance < $amount) {
        return [
            'status' => false,
            'message' => 'Insufficient balance',
            'balance' => $wallet->balance
        ];
    }

    try {

        DB::beginTransaction();

        $reference = 'ELEC-' . uniqid();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'buy_electricity',
            'amount' => $amount,
            'status' => 'pending',
            'reference' => $reference,
            'phone_number' => $data['phone_number'],
            'meta' => json_encode([
                'electricity_distributor_id' => $data['electricity_distributor_id'],
                'meter_number' => $data['meter_number'],
                'meter_type' => $data['meter_type'],
                'name' => $data['name']
            ])
        ]);

        /*
        |--------------------------------------------------------------------------
        | SEND REQUEST TO EXTERNAL VTU API
        |--------------------------------------------------------------------------
        */

        $payload = [
            "meter_number" => $data['meter_number'],
            "meter_type" => $data['meter_type'],
            "phone_number" => $data['phone_number'],
            "amount" => $amount,
            "name" => $data['name'],
            "electricity_distributor_id" => $data['electricity_distributor_id']
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Token ' . config('services.vtu.key'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post(
            config('services.vtu.purchase_url') . "electricity",
            $payload
        );

        $body = $response->json();

        /*
        |--------------------------------------------------------------------------
        | HANDLE PROVIDER RESPONSE
        |--------------------------------------------------------------------------
        */

        if (!$response->successful()) {

            $transaction->update([
                'status' => 'failed'
            ]);

            DB::commit();

            return [
                'status' => false,
                'message' => 'VTU provider request failed',
                'provider_response' => $body,
                'balance' => $wallet->fresh()->balance
            ];
        }

        $providerStatus = strtolower(
            $body['status'] ?? $body['Status'] ?? ''
        );

        if ($providerStatus === 'success' || $providerStatus === 'successful') {

            $wallet->decrement('balance', $amount);

            $transaction->update([
                'status' => 'success',
                'meta' => json_encode(array_merge(
                    json_decode($transaction->meta, true),
                    [
                        'token' => $body['token'] ?? null,
                        'provider_response' => $body
                    ]
                ))
            ]);
        }
        elseif ($providerStatus === 'pending') {

            $transaction->update([
                'status' => 'pending'
            ]);
        }
        else {

            $transaction->update([
                'status' => 'failed'
            ]);
        }

        DB::commit();

        return [
            'status' => true,
            'transaction' => $transaction,
            'provider_response' => $body,
            'balance' => $wallet->fresh()->balance
        ];

    }
    catch (\Exception $e) {

        DB::rollBack();

        return [
            'status' => false,
            'message' => $e->getMessage(),
            'balance' => $wallet?->fresh()->balance ?? 0
        ];
    }
}
}
