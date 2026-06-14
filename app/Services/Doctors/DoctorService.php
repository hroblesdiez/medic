<?php

namespace App\Services\Doctors;

use WP_Post;

class DoctorService
{
    public function getDoctorData($doctor): array
    {
        if (is_numeric($doctor)) {
            $doctor = get_post($doctor);
        }

        if (!$doctor instanceof WP_Post || $doctor->post_type !== 'doctors') {
            return [];
        }

        $id = $doctor->ID;

        $icon_id = carbon_get_post_meta($id, 'doctor_icon');
        $image_url = get_the_post_thumbnail_url($id, 'full')
            ?: 'https://via.placeholder.com/600x600';

        $specialities = get_the_terms($id, 'speciality_type');
        $specialities_list = !is_wp_error($specialities) && !empty($specialities)
            ? array_map(fn($term) => $term->name, $specialities)
            : [];

        $bio = carbon_get_post_meta($id, 'doctor_bio');

        $short_bio = wp_trim_words(
            wp_strip_all_tags($bio),
            30
        );

        return [
            'id' => $id,
            'title' => get_the_title($id),
            'name' => get_the_title($id),
            'speciality' => !empty($specialities_list) ? $specialities_list[0] : '',
            'location' => carbon_get_post_meta($id, 'doctor_location') ?: '',
            'price' => carbon_get_post_meta($id, 'doctor_price') ?: '',
            'experience' => carbon_get_post_meta($id, 'doctor_years_experience') ?: '',
            'image' => $image_url,
            'bio' => $bio,
            'specialities' => $specialities_list,
            'qualifications' => carbon_get_post_meta($id, 'doctor_qualifications') ?: '',
            'available_slots' => carbon_get_post_meta($id, 'doctor_available_slots') ?: '',
            'url' => get_permalink($id),
            'booking_url' => home_url("/book-appointment?doctor={$id}"),
            'seo' => [
                'title' => get_the_title($id) . ' | Medical Clinic',
                'description' => $short_bio,
            ]
        ];
    }
}
