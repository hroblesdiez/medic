export default (config) => ({
  page: 1,
  maxPages: config.initialMaxPages,
  loading: false,
  resultsHtml: '',
  apiUrl: config.apiUrl,
  hasLoadedMore: false,

  async loadMore() {
    if (this.page >= this.maxPages || this.loading) return;

    try {
      this.loading = true;
      this.page++;
      this.hasLoadedMore = true;

      const params = new URLSearchParams();
      params.append('page', this.page);

      const response = await fetch(`${this.apiUrl}?${params.toString()}`);

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      this.resultsHtml += data.html || '';
      this.maxPages = data.max_pages || 1;
    } catch (error) {
      console.error('Load More Error:', error);
    } finally {
      this.loading = false;
    }
  },
});
