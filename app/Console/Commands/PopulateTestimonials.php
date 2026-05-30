<?php

namespace App\Console\Commands;

use Roots\Acorn\Console\Commands\Command;

class PopulateTestimonials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medic:populate-testimonials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates testimonial CPT with Carbon Fields meta data.';

    /**
     * Testimonial data to populate.
     *
     * @var array
     */
    protected $testimonials = [
        [
            'title' => 'Elena Rodriguez Testimonial',
            'subtitle' => 'Great Experience',
            'main_title' => 'Compassionate Doctors',
            'text' => 'Medic has been a life-changer for me. Their doctors are not just experts in their fields, but truly compassionate human beings who take the time to understand your needs. I couldn\'t be happier with the results.',
            'name' => 'Elena Rodriguez',
            'city' => 'Birmingham, UK',
            'image_id' => 308,
        ],
        [
            'title' => 'Michael Chen Testimonial',
            'subtitle' => 'Expert Care',
            'main_title' => 'Truly Modern Clinic',
            'text' => 'The level of expertise here is unparalleled. I\'ve never seen such advanced medical technology combined with such a human and warm approach. My health has improved significantly thanks to their dedicated specialists.',
            'name' => 'Michael Chen',
            'city' => 'Manchester, UK',
            'image_id' => 307,
        ],
        [
            'title' => 'Sarah Johnson Testimonial',
            'subtitle' => 'Outstanding Service',
            'main_title' => 'Very Professional Team',
            'text' => 'I am absolutely delighted with the service at Medic. From the moment I walked in, I felt cared for and respected. The treatment was successful, and the staff\'s kindness made all the difference in my recovery.',
            'name' => 'Sarah Johnson',
            'city' => 'London, UK',
            'image_id' => 306,
        ],
        [
            'title' => 'David Wilson Testimonial',
            'subtitle' => 'Life Changing',
            'main_title' => 'Best Medical Center',
            'text' => 'I was struggling with chronic pain for years until I found Medic. The personalized treatment plan they developed for me was incredibly effective. The facilities are top-notch and the atmosphere is very welcoming.',
            'name' => 'David Wilson',
            'city' => 'Bristol, UK',
            'image_id' => 299,
        ],
        [
            'title' => 'Emma Thompson Testimonial',
            'subtitle' => 'Highly Recommended',
            'main_title' => 'Exceptional Pediatric Care',
            'text' => 'Taking my children to Medic has always been a positive experience. The pediatricians are wonderful with kids and always explain everything clearly to parents. It\'s a relief to have such reliable care nearby.',
            'name' => 'Emma Thompson',
            'city' => 'Leeds, UK',
            'image_id' => 300,
        ],
        [
            'title' => 'James Miller Testimonial',
            'subtitle' => 'First-Class Treatment',
            'main_title' => 'Fast and Effective',
            'text' => 'I needed urgent care and Medic delivered. The wait times were minimal, and the diagnostic equipment was impressive. I received a clear diagnosis and treatment plan within hours. Truly first-class medical service.',
            'name' => 'James Miller',
            'city' => 'Liverpool, UK',
            'image_id' => 301,
        ]
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Starting testimonial population...');

        foreach ($this->testimonials as $data) {
            // Check if post exists by title
            $existing_post = get_page_by_title($data['title'], OBJECT, 'testimonials');

            if ($existing_post) {
                $post_id = $existing_post->ID;
                $this->info("Updating existing testimonial: {$data['title']} (ID: {$post_id})");
                
                // Update post content if empty (optional but good practice)
                if (empty($existing_post->post_content)) {
                    wp_update_post([
                        'ID' => $post_id,
                        'post_content' => $data['text']
                    ]);
                }
            } else {
                $post_id = wp_insert_post([
                    'post_title' => $data['title'],
                    'post_type' => 'testimonials',
                    'post_status' => 'publish',
                    'post_content' => $data['text'],
                ]);

                if (is_wp_error($post_id)) {
                    $this->error("Error creating testimonial '{$data['title']}': " . $post_id->get_error_message());
                    continue;
                }

                $this->info("Created new testimonial: {$data['title']} (ID: {$post_id})");
            }

            // Set Featured Image if not already set or if it's a new post
            if (! has_post_thumbnail($post_id)) {
                set_post_thumbnail($post_id, $data['image_id']);
                $this->info("Set featured image (ID: {$data['image_id']}) for testimonial ID: {$post_id}");
            }

            // Populate Carbon Fields meta using carbon_set_post_meta
            // We verify field keys against TestimonialsFields.php: 
            // testimonial_image, testimonial_subtitle, testimonial_title, testimonial_text, testimonial_name, testimonial_city

            carbon_set_post_meta($post_id, 'testimonial_subtitle', $data['subtitle']);
            carbon_set_post_meta($post_id, 'testimonial_title', $data['main_title']);
            carbon_set_post_meta($post_id, 'testimonial_text', $data['text']);
            carbon_set_post_meta($post_id, 'testimonial_name', $data['name']);
            carbon_set_post_meta($post_id, 'testimonial_city', $data['city']);
            
            // Also set the carbon field image to match featured image for consistency
            carbon_set_post_meta($post_id, 'testimonial_image', $data['image_id']);

            $this->line("Successfully populated all Carbon Fields for: {$data['name']}");
        }

        $this->info('Testimonial population finished successfully.');
    }
}
