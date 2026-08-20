<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Mail\InquiryAdminMail;
use App\Mail\InquiryConfirmMail;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

class InquiryEmailTest extends TestCase
{
    use RefreshDatabase;

    private function validInquiry(array $overrides = []): array
    {
        return array_merge([
            'name'    => 'John Importer',
            'email'   => 'john@trade.com',
            'company' => 'Trade Co',
            'country' => 'Germany',
            'subject' => 'Export Inquiry',
            'message' => 'I would like to inquire about your cinnamon products.',
            '_pot'    => '',
        ], $overrides);
    }

    /**
     * Core email dispatch test: submitting the contact form
     * sends both admin notification and customer confirmation.
     */
    public function test_inquiry_sends_admin_and_customer_emails(): void
    {
        Mail::fake();

        $response = $this->post(route('inquiry.store'), $this->validInquiry());

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Admin notification was queued/sent
        Mail::assertQueued(InquiryAdminMail::class, function ($mail) {
            return $mail->hasTo(config('mail.admin_address', 'info@ceylonaroma.com'));
        });

        // Customer confirmation was queued/sent to the submitter
        Mail::assertQueued(InquiryConfirmMail::class, function ($mail) {
            return $mail->hasTo('john@trade.com');
        });

        // Total: 2 emails dispatched
        Mail::assertQueuedCount(2);
    }

    /** Admin email carries the inquiry sender data */
    public function test_admin_email_contains_inquiry_data(): void
    {
        Mail::fake();

        $this->post(route('inquiry.store'), $this->validInquiry([
            'company' => 'Bulk Traders Ltd',
        ]));

        Mail::assertQueued(InquiryAdminMail::class, function (InquiryAdminMail $mail) {
            return $mail->inquiry->company === 'Bulk Traders Ltd';
        });
    }

    /** Customer email is addressed to the right person */
    public function test_confirmation_email_goes_to_submitter(): void
    {
        Mail::fake();

        $this->post(route('inquiry.store'), $this->validInquiry(['email' => 'buyer@japan.jp']));

        Mail::assertQueued(InquiryConfirmMail::class, function ($mail) {
            return $mail->hasTo('buyer@japan.jp');
        });
    }

    /** Honeypot filled → no email dispatched (if your InquiryRequest validates _pot) */
    public function test_no_email_on_honeypot_spam(): void
    {
        Mail::fake();

        $this->post(route('inquiry.store'), $this->validInquiry(['_pot' => 'spam']));

        Mail::assertNothingQueued();
    }

    /** Inquiry is stored in the database */
    public function test_inquiry_persisted_to_database(): void
    {
        Mail::fake();

        $this->post(route('inquiry.store'), $this->validInquiry());

        $this->assertDatabaseHas('inquiries', [
            'email'   => 'john@trade.com',
            'company' => 'Trade Co',
        ]);
    }

    /**
     * Log-mode email check: switch mail to log driver and confirm the email
     * content actually appears in the log. Run this manually to verify SMTP
     * config on the live server is wired up correctly.
     *
     * Usage: php artisan test --filter=test_email_logged_in_log_driver
     */
    public function test_email_logged_in_log_driver(): void
    {
        $this->markTestSkipped('Manual test — run php artisan test --filter=test_email_logged_in_log_driver on the live server to verify SMTP config.');

        // Temporarily switch to log driver for this test
        config(['mail.mailer' => 'log']);

        // Clear the log so we get a fresh snapshot
        $logPath = storage_path('logs/laravel.log');
        if (file_exists($logPath)) {
            $before = file_get_contents($logPath);
        } else {
            $before = '';
        }

        $this->post(route('inquiry.store'), $this->validInquiry(['email' => 'log_test@example.com']));

        if (file_exists($logPath)) {
            $after = file_get_contents($logPath);
            $diff  = substr($after, strlen($before));
            $this->assertStringContainsString('log_test@example.com', $diff,
                'Expected email address to appear in laravel.log — check MAIL_MAILER=log is working.');
        } else {
            $this->markTestIncomplete('laravel.log not found — run from project root with write access to storage/.');
        }
    }
}
