<?php

namespace App\Services;

use Illuminate\Support\Facades\Vite;

class SchemaService
{
    public function register(): void
    {
        add_action('wp_head', [$this, 'outputSchemas'], 1);
    }

    public function outputSchemas(): void
    {
        try {
            if (is_admin()) {
                return;
            }

            $schemas = [];

            $schemas[] = $this->organizationSchema();
            $schemas[] = $this->websiteSchema();
            $schemas[] = $this->breadcrumbListSchema();

            if (is_singular('post')) {
                $schemas[] = $this->articleSchema();
            }

            if (is_singular('doctors')) {
                $schemas[] = $this->physicianSchema();
            }

            if (is_front_page()) {
                $faqSchema = $this->faqPageSchema();
                if ($faqSchema) {
                    $schemas[] = $faqSchema;
                }
            }

            $schemas = array_values(array_filter($schemas));

            if (empty($schemas)) {
                return;
            }

            $encoded = wp_json_encode(count($schemas) === 1 ? $schemas[0] : $schemas, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
            echo '<script type="application/ld+json">'."\n";
            echo $encoded."\n";
            echo '</script>'."\n";
        } catch (\Throwable $e) {
            error_log('SchemaService error on '.($_SERVER['REQUEST_URI'] ?? 'unknown').': '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine());
        }
    }

    private function organizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'MedicalBusiness',
            '@id' => home_url('/').'#organization',
            'name' => get_bloginfo('name'),
            'url' => home_url('/'),
            'logo' => wp_get_attachment_image_url(carbon_get_theme_option('medic_logo'), 'full') ?: '',
            'image' => wp_get_attachment_image_url(carbon_get_theme_option('medic_default_hero_image'), 'full') ?: '',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Warsaw',
                'addressCountry' => 'PL',
            ],
            'telephone' => carbon_get_theme_option('medic_contact_phone') ?: '+48 152 568 897',
        ];
    }

    private function websiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => home_url('/').'#website',
            'url' => home_url('/'),
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'publisher' => [
                '@id' => home_url('/').'#organization',
            ],
            'potentialAction' => [
                [
                    '@type' => 'SearchAction',
                    'target' => [
                        '@type' => 'EntryPoint',
                        'urlTemplate' => home_url('/?s={search_term_string}'),
                    ],
                    'query-input' => 'required name=search_term_string',
                ],
            ],
        ];
    }

    private function breadcrumbListSchema(): array
    {
        global $wp_query;

        $crumbs = [];
        $position = 1;

        $crumbs[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'Home',
            'item' => home_url('/'),
        ];

        if (is_singular('doctors')) {
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Doctors',
                'item' => get_post_type_archive_link('doctors'),
            ];
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title(),
                'item' => get_permalink(),
            ];
        } elseif (is_singular('speciality')) {
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Specialities',
                'item' => get_post_type_archive_link('speciality'),
            ];
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title(),
                'item' => get_permalink(),
            ];
        } elseif (is_singular('post')) {
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Blog',
                'item' => get_permalink(get_option('page_for_posts')),
            ];
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title(),
                'item' => get_permalink(),
            ];
        } elseif (is_post_type_archive('doctors')) {
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Doctors',
                'item' => get_post_type_archive_link('doctors'),
            ];
        } elseif (is_post_type_archive('speciality')) {
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Specialities',
                'item' => get_post_type_archive_link('speciality'),
            ];
        } elseif (is_page()) {
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title(),
                'item' => get_permalink(),
            ];
        } elseif (is_404()) {
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Page Not Found',
            ];
        } elseif (is_search()) {
            $crumbs[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Search Results',
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            '@id' => home_url('/').'#breadcrumb',
            'itemListElement' => $crumbs,
        ];
    }

    private function articleSchema(): array
    {
        $post = get_post();
        if (! $post) {
            return [];
        }

        $authorId = $post->post_author;
        $authorName = get_the_author_meta('display_name', $authorId);
        $authorPhoto = carbon_get_user_meta($authorId, 'author_photo')
            ?: Vite::asset('resources/images/authors/author1.png');

        $excerpt = ! empty($post->post_excerpt)
            ? $post->post_excerpt
            : wp_trim_words(wp_strip_all_tags($post->post_content), 30);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            '@id' => get_permalink($post).'#article',
            'headline' => get_the_title($post),
            'description' => $excerpt,
            'image' => get_the_post_thumbnail_url($post, 'full') ?: '',
            'datePublished' => get_the_date('c', $post),
            'dateModified' => get_the_modified_date('c', $post),
            'author' => [
                '@type' => 'Person',
                'name' => $authorName,
                'image' => $authorPhoto,
            ],
            'publisher' => [
                '@id' => home_url('/').'#organization',
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => get_permalink($post),
            ],
        ];
    }

    private function physicianSchema(): array
    {
        $id = get_the_ID();
        if (! $id) {
            return [];
        }

        $name = get_the_title();
        $image = get_the_post_thumbnail_url($id, 'full');
        $bio = carbon_get_post_meta($id, 'doctor_bio');
        $price = carbon_get_post_meta($id, 'doctor_price');
        $location = carbon_get_post_meta($id, 'doctor_location');
        $experience = carbon_get_post_meta($id, 'doctor_years_experience');

        $specialities = get_the_terms($id, 'speciality_type');
        $specialityNames = ! is_wp_error($specialities) && ! empty($specialities)
            ? array_map(fn ($term) => $term->name, $specialities)
            : [];

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Physician',
            '@id' => get_permalink($id).'#physician',
            'name' => $name,
            'description' => wp_strip_all_tags(wp_trim_words($bio ?: '', 40), true),
            'image' => $image ?: '',
            'url' => get_permalink($id),
            'medicalSpecialty' => $specialityNames,
            'knowsAbout' => $specialityNames,
            'memberOf' => [
                '@id' => home_url('/').'#organization',
            ],
        ];

        if (! empty($location)) {
            $schema['location'] = [
                '@type' => 'Place',
                'name' => $location,
            ];
        }

        if (! empty($experience)) {
            $schema['yearsOfExperience'] = (int) $experience;
        }

        if (! empty($price)) {
            $schema['offers'] = [
                '@type' => 'Offer',
                'price' => $price,
                'priceCurrency' => 'PLN',
                'priceValidUntil' => date('Y-12-31', strtotime('+1 year')),
                'availability' => 'https://schema.org/InStock',
                'url' => get_permalink($id),
            ];
        }

        return $schema;
    }

    private function faqPageSchema(): ?array
    {
        $faqs = get_posts([
            'post_type' => 'faq',
            'posts_per_page' => 5,
            'post_status' => 'publish',
        ]);

        if (empty($faqs)) {
            return null;
        }

        $mainEntity = [];

        foreach ($faqs as $faq) {
            $question = carbon_get_post_meta($faq->ID, 'faq_question');
            $answer = carbon_get_post_meta($faq->ID, 'faq_answer');

            if (empty($question) || empty($answer)) {
                continue;
            }

            $mainEntity[] = [
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => wp_strip_all_tags($answer),
                ],
            ];
        }

        if (empty($mainEntity)) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            '@id' => home_url('/').'#faq',
            'mainEntity' => $mainEntity,
        ];
    }
}
