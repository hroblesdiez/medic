<?php

namespace App\Services\Doctors;

use WP_Post;

class DoctorService
{
    /**
     * Get a normalized doctor object by ID or Post object.
     *
     * @param int|WP_Post $doctor
     * @return array
     */
    public function getDoctorData($doctor): array
    {
        if (is_numeric($doctor)) {
            $doctor = get_post($doctor);
        }

        if (!$doctor instanceof WP_Post || $doctor->post_type !== 'doctors') {
            return [];
        }

        $id = $doctor->ID;

        // Normalizing meta data
        $icon_id = carbon_get_post_meta($id, 'doctor_icon');
        $image_url = wp_get_attachment_image_url($icon_id, 'full') ?: 'https://via.placeholder.com/600x600';
        
        $specialities = get_the_terms($id, 'speciality_type');
        $specialities_list = !is_wp_error($specialities) && !empty($specialities) 
            ? array_map(fn($term) => $term->name, $specialities) 
            : [];

        $bio = apply_filters('the_content', $doctor->post_content);
        $short_bio = wp_trim_words(strip_tags($doctor->post_content), 30);

        return [
            'id' => $id,
            'title' => get_the_title($id),
            'name' => carbon_get_post_meta($id, 'doctor_name') ?: get_the_title($id),
            'speciality' => carbon_get_post_meta($id, 'doctor_speciality'),
            'location' => carbon_get_post_meta($id, 'doctor_location'),
            'price' => carbon_get_post_meta($id, 'doctor_price'),
            'experience' => carbon_get_post_meta($id, 'doctor_experience'),
            'image' => $image_url,
            'bio' => $bio,
            'specialities' => $specialities_list,
            'availability' => carbon_get_post_meta($id, 'doctor_availability') ?: [],
            'seo' => [
                'title' => get_the_title($id) . ' | Medical Clinic',
                'description' => $short_bio,
            ]
        ];
    }
}
