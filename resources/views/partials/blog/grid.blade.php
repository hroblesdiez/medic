  <div class="flex flex-wrap justify-center gap-8 lg:gap-12">
    <template x-if="!hasLoadedMore">
      <div class="contents">
        @foreach($initial_posts as $post)
        {{-- Envoltorio para controlar el ancho en el layout Flex --}}
        <div class="w-full md:w-[calc(50%-1rem)] lg:w-[calc(33.333%-2rem)]">
          <x-blog.card :post="$post" />
        </div>
        @endforeach
      </div>
    </template>

    <div class="contents" x-html="resultsHtml"></div>
  </div>