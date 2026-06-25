<?php

namespace App\Fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class DoctorsFields
{
    public function register(): void
    {
        Container::make('post_meta', __('Doctor Information'))
            ->where('post_type', '=', 'doctors')
            ->add_fields([
                Field::make('text', 'doctor_location', __('Location')),
                Field::make('text', 'doctor_price', __('Price/Hourly Rate'))
                    ->set_attribute('type', 'number'),
                Field::make('text', 'doctor_years_experience', __('Years of Experience'))
                    ->set_attribute('type', 'number'),
                Field::make('rich_text', 'doctor_bio', __('Bio')),
                Field::make('text', 'doctor_qualifications', __('Qualifications')),
                Field::make('text', 'doctor_available_slots', __('Available Slots'))
                    ->set_help_text(__('Example: 08:00 - 14:00 or 15:00 - 21:00')),
                Field::make('separator', 'doctor_seo_separator', __('SEO Settings')),
                Field::make('text', 'doctor_seo_title', __('Custom SEO Title'))
                    ->set_help_text(__('Leave empty to use the doctor name. Recommended: 50-60 characters.')),
                Field::make('textarea', 'doctor_seo_description', __('Custom SEO Meta Description'))
                    ->set_help_text(__('Leave empty to auto-generate from bio. Recommended: 150-160 characters.')),
            ]);
    }
}
