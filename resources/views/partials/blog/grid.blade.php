<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
  <template x-if="!hasLoadedMore">
    <div class="contents">
      @foreach($initial_posts as $post)
        <x-blog.card :post="$post" />
      @endforeach
    </div>
  </template>

  <div class="contents" x-html="resultsHtml"></div>
</div>
