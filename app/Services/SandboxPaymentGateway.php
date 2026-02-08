<?php

namespace App\Services;

class SandboxPaymentGateway
{
    /**
     * Test card numbers and their expected results
     */
    const CARD_SUCCESS = '4242424242424242';
    const CARD_DECLINED_INSUFFICIENT_FUNDS = '4000000000000002';
    const CARD_DECLINED_INVALID = '4000000000000127';
    const CARD_DECLINED_EXPIRED = '4000000000000069';

    /**
     * Process a payment charge
     *
     * @param array $data Payment data
     * @return array Result with success status and details
     */
    public function charge(array $data): array
    {
        // Extract payment details
        $amount = $data['amount'] ?? 0;
        $cardNumber = $this->cleanCardNumber($data['card_number'] ?? '');
        $cardExpiry = $data['card_expiry'] ?? '';
        $cardCvc = $data['card_cvc'] ?? '';

        // Validate card details
        $validation = $this->validateCard($cardNumber, $cardExpiry, $cardCvc);
        if (!$validation['valid']) {
            return [
                'success' => false,
                'message' => $validation['message'],
                'transaction_id' => null,
            ];
        }

        // Simulate payment processing based on card number
        $result = $this->processPayment($cardNumber, $amount);

        return $result;
    }

    /**
     * Validate card details
     *
     * @param string $cardNumber
     * @param string $cardExpiry
     * @param string $cardCvc
     * @return array
     */
    private function validateCard(string $cardNumber, string $cardExpiry, string $cardCvc): array
    {
        // Validate card number length
        if (strlen($cardNumber) < 13 || strlen($cardNumber) > 19) {
            return ['valid' => false, 'message' => 'Invalid card number length'];
        }

        // Validate card number is numeric
        if (!ctype_digit($cardNumber)) {
            return ['valid' => false, 'message' => 'Card number must contain only digits'];
        }

        // Validate Luhn algorithm
        if (!$this->luhnCheck($cardNumber)) {
            return ['valid' => false, 'message' => 'Invalid card number'];
        }

        // Validate expiry format (MM/YY)
        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $cardExpiry)) {
            return ['valid' => false, 'message' => 'Invalid expiry date format (use MM/YY)'];
        }

        // Validate expiry is in the future
        [$month, $year] = explode('/', $cardExpiry);
        $expiryDate = \Carbon\Carbon::createFromDate('20' . $year, $month, 1)->endOfMonth();
        if ($expiryDate->isPast()) {
            return ['valid' => false, 'message' => 'Card has expired'];
        }

        // Validate CVC
        if (strlen($cardCvc) < 3 || strlen($cardCvc) > 4 || !ctype_digit($cardCvc)) {
            return ['valid' => false, 'message' => 'Invalid CVC'];
        }

        return ['valid' => true, 'message' => 'Valid'];
    }

    /**
     * Process payment based on card number
     *
     * @param string $cardNumber
     * @param float $amount
     * @return array
     */
    private function processPayment(string $cardNumber, float $amount): array
    {
        // Simulate processing delay
        usleep(500000); // 0.5 seconds

        // Check for specific test cards
        switch ($cardNumber) {
            case self::CARD_DECLINED_INSUFFICIENT_FUNDS:
                return [
                    'success' => false,
                    'message' => 'Your card has insufficient funds',
                    'transaction_id' => null,
                ];

            case self::CARD_DECLINED_INVALID:
                return [
                    'success' => false,
                    'message' => 'Your card was declined',
                    'transaction_id' => null,
                ];

            case self::CARD_DECLINED_EXPIRED:
                return [
                    'success' => false,
                    'message' => 'Your card has expired',
                    'transaction_id' => null,
                ];

            default:
                // All other valid cards succeed
                return [
                    'success' => true,
                    'message' => 'Payment successful',
                    'transaction_id' => $this->generateTransactionId(),
                    'amount' => $amount,
                    'currency' => 'LKR',
                ];
        }
    }

    /**
     * Luhn algorithm for card number validation
     *
     * @param string $cardNumber
     * @return bool
     */
    private function luhnCheck(string $cardNumber): bool
    {
        $sum = 0;
        $length = strlen($cardNumber);
        $parity = $length % 2;

        for ($i = 0; $i < $length; $i++) {
            $digit = (int) $cardNumber[$i];

            if ($i % 2 == $parity) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return ($sum % 10) == 0;
    }

    /**
     * Clean card number (remove spaces and dashes)
     *
     * @param string $cardNumber
     * @return string
     */
    private function cleanCardNumber(string $cardNumber): string
    {
        return preg_replace('/[\s\-]/', '', $cardNumber);
    }

    /**
     * Generate a unique transaction ID
     *
     * @return string
     */
    private function generateTransactionId(): string
    {
        return 'SANDBOX_' . time() . '_' . bin2hex(random_bytes(8));
    }

    /**
     * Get test card information
     *
     * @return array
     */
    public static function getTestCards(): array
    {
        return [
            [
                'number' => '4242 4242 4242 4242',
                'result' => 'Success',
                'description' => 'Payment will succeed',
            ],
            [
                'number' => '4000 0000 0000 0002',
                'result' => 'Declined',
                'description' => 'Insufficient funds',
            ],
            [
                'number' => '4000 0000 0000 0127',
                'result' => 'Declined',
                'description' => 'Invalid card',
            ],
            [
                'number' => '4000 0000 0000 0069',
                'result' => 'Declined',
                'description' => 'Expired card',
            ],
        ];
    }
}
