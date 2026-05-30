@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <article @php(post_class('bg-white'))>
      {{-- Header Section --}}
      <header class="pt-12 lg:pt-20 pb-10 lg:pb-16 bg-[var(--color-surface-soft)]">
        <div class="max-w-4xl mx-auto px-4">
          <div class="flex flex-wrap items-center gap-4 mb-8">
            @php($tags = get_the_tags())
            @if($tags)
              @foreach($tags as $tag)
                <x-blog.tag-pill :tag="$tag" />
              @endforeach
            @endif
          </div>

          <h1 class="text-3xl lg:text-5xl font-bold text-[var(--color-text-primary)] mb-8 leading-tight">
            {!! get_the_title() !!}
          </h1>

          <div class="flex flex-wrap items-center justify-between gap-6 border-t border-[var(--color-border-light)] pt-8">
            <x-blog.meta :post="get_post()" />
            
            <div class="flex items-center gap-4">
               {{-- Social Share Placeholder --}}
               <span class="text-xs font-bold text-[var(--color-text-muted)] uppercase tracking-widest">Share:</span>
               <div class="flex gap-2">
                  <div class="w-8 h-8 rounded-full bg-white border border-[var(--color-border-light)] flex items-center justify-center text-[var(--color-text-secondary)] hover:bg-[var(--color-primary)] hover:text-white transition-all cursor-pointer">
                    <i class="fab fa-facebook-f text-xs"></i>
                  </div>
                  <div class="w-8 h-8 rounded-full bg-white border border-[var(--color-border-light)] flex items-center justify-center text-[var(--color-text-secondary)] hover:bg-[var(--color-primary)] hover:text-white transition-all cursor-pointer">
                    <i class="fab fa-twitter text-xs"></i>
                  </div>
               </div>
            </div>
          </div>
        </div>
      </header>

      {{-- Featured Image --}}
      <div class="max-w-6xl mx-auto px-4 -mt-10 lg:-mt-16 mb-16 lg:mb-24">
        <div class="aspect-[21/9] rounded-[var(--radius-2xl)] overflow-hidden shadow-2xl border-4 border-white">
          @if(has_post_thumbnail())
            {!! get_the_post_thumbnail(null, 'full', ['class' => 'w-full h-full object-cover']) !!}
          @endif
        </div>
      </div>

      {{-- Content Section --}}
      <div class="max-w-4xl mx-auto px-4">
        <div class="prose prose-lg max-w-none 
          prose-headings:text-[var(--color-text-primary)] prose-headings:font-bold
          prose-p:text-[var(--color-text-secondary)] prose-p:leading-relaxed
          prose-a:text-[var(--color-primary)] prose-a:no-underline hover:prose-a:underline
          prose-blockquote:border-l-4 prose-blockquote:border-[var(--color-primary)] prose-blockquote:bg-[var(--color-primary-soft)] prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:rounded-r-xl prose-blockquote:italic prose-blockquote:text-[var(--color-text-primary)]
          prose-img:rounded-2xl prose-img:shadow-lg
          mb-20">
          {!! get_the_content() !!}
        </div>

        {{-- Author Box --}}
        <div class="mb-20">
          <x-blog.author-box :authorId="get_the_author_meta('ID')" />
        </div>

        {{-- Related Posts --}}
        <x-blog.related-posts :currentPostId="get_the_ID()" />

        {{-- CTA Card --}}
        <div class="mt-20 mb-20">
          <x-blog.cta-card />
        </div>
      </div>
    </article>
  @endwhile
@endsection
