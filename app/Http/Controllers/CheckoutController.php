<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Services\Payment\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Initiate checkout: create enrollment + redirect to payment gateway.
     */
    public function initiate(Request $request, Course $course)
    {
        $user = $request->user();

        // Check if already enrolled
        $existing = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->whereIn('status', ['active', 'completed'])
            ->first();

        if ($existing) {
            return redirect()->route('courses.show', $course->slug)
                ->with('info', 'Ya estás inscrito en este curso.');
        }

        // Check capacity
        if (! $course->hasCapacity()) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Lo sentimos, los cupos están agotados.');
        }

        $gateway = app(PaymentGatewayInterface::class);

        try {
            // Create or reuse pending enrollment
            $enrollment = DB::transaction(function () use ($user, $course) {
                return Enrollment::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'status' => 'pending_payment',
                    ]
                );
            });

            // Create checkout session with payment gateway
            $checkout = $gateway->createCheckoutSession($enrollment);

            // Store the payment record as pending
            Payment::create([
                'enrollment_id' => $enrollment->id,
                'user_id' => $user->id,
                'gateway' => $gateway->getIdentifier(),
                'gateway_reference' => $checkout['reference'],
                'amount_cop' => $course->price_cop,
                'status' => 'PENDING',
            ]);

            // For ePayco (client-side widget), return config to the view
            if ($gateway->getIdentifier() === 'epayco' && isset($checkout['epayco_config'])) {
                return view('payments.epayco-checkout', [
                    'config' => $checkout['epayco_config'],
                    'course' => $course,
                ]);
            }

            // For Bold or other redirect-based gateways
            if (! empty($checkout['url'])) {
                return redirect()->away($checkout['url']);
            }

            // Fallback: redirect to course with error
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'No se pudo iniciar el proceso de pago. Intenta nuevamente.');

        } catch (\Exception $e) {
            Log::error('Checkout initiation failed', [
                'user_id' => $user->id,
                'course_id' => $course->id,
                'gateway' => $gateway->getIdentifier(),
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Error al procesar el pago. Por favor intenta nuevamente.');
        }
    }
}
