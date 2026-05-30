<?php

namespace App\Console\Commands;

use Roots\Acorn\Console\Commands\Command;

class PopulateFAQ extends Command
{
    protected $signature = 'medic:populate-faq';
    protected $description = 'Populate FAQ CPT with demo data';

    public function handle()
    {
        $faqs = [
            [
                'question' => 'How can I schedule an appointment?',
                'response' => 'You can schedule an appointment by clicking the "Book Now" button on our homepage or by calling our office directly.'
            ],
            [
                'question' => 'Do you accept insurance plans?',
                'response' => 'Yes, we accept most major insurance plans. Please contact our front desk to verify your coverage before your visit.'
            ],
            [
                'question' => 'What should I bring to my first visit?',
                'response' => 'Please bring your photo ID, insurance card, and a list of any current medications you are taking.'
            ],
            [
                'question' => 'Are telehealth appointments available?',
                'response' => 'Absolutely, we offer telehealth services for follow-up consultations and certain general medical inquiries.'
            ],
            [
                'question' => 'What are your office hours?',
                'response' => 'Our office is open from Monday to Friday, 9:00 AM to 6:00 PM, and Saturday from 10:00 AM to 2:00 PM.'
            ],
        ];

        foreach ($faqs as $faqData) {
            $post_id = wp_insert_post([
                'post_title' => $faqData['question'],
                'post_type' => 'faq',
                'post_status' => 'publish',
            ]);

            if ($post_id) {
                carbon_set_post_meta($post_id, 'faq_question', $faqData['question']);
                carbon_set_post_meta($post_id, 'faq_response', $faqData['response']);
            }
        }

        $this->info('FAQ populated successfully!');
    }
}
