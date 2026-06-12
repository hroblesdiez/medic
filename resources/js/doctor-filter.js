export default (config) => ({
  filters: {
    speciality: config.initialSpeciality || '',
    min_price: 0,
    price: config.maxPrice,
    location: '',
  },

  maxPrice: config.maxPrice,
  page: 1,
  maxPages: config.initialMaxPages,
  foundPosts: config.initialCount || 0,
  loading: false,
  hasFiltered: false,
  resultsHtml: '',
  apiUrl: config.apiUrl,

  buildParams() {
    const params = new URLSearchParams();

    if (this.filters.speciality) {
      params.append('speciality', this.filters.speciality);
    }

    params.append('min_price', this.filters.min_price);
    params.append('max_price', this.filters.price);
    params.append('location', this.filters.location);
    params.append('page', this.page);

    return params;
  },

  async filter() {
    try {
      this.loading = true;
      this.hasFiltered = true;
      this.page = 1;

      const params = this.buildParams();
      const response = await fetch(`${this.apiUrl}?${params.toString()}`);

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      this.resultsHtml = data.html || '';
      this.maxPages = data.max_pages || 1;
      this.foundPosts = data.found_posts || 0;
    } catch (error) {
      console.error('WordPress Filter Error:', error);
      this.resultsHtml = '';
    } finally {
      this.loading = false;
    }
  },

  async loadMore() {
    if (this.page >= this.maxPages || this.loading) return;

    try {
      this.loading = true;

      if (!this.hasFiltered) {
        const initialParams = this.buildParams();
        initialParams.set('page', 1);
        const initialResponse = await fetch(
          `${this.apiUrl}?${initialParams.toString()}`,
        );

        if (initialResponse.ok) {
          const initialData = await initialResponse.json();
          this.resultsHtml = initialData.html || '';
        }
      }

      this.page++;
      const params = this.buildParams();
      const response = await fetch(`${this.apiUrl}?${params.toString()}`);

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      this.resultsHtml += data.html || '';
      this.maxPages = data.max_pages || 1;
      this.foundPosts = data.found_posts || 0;
      this.hasFiltered = true;
    } catch (error) {
      console.error('Load More Error:', error);
    } finally {
      this.loading = false;
    }
  },

  resetFilters() {
    this.filters = {
      speciality: '',
      min_price: 0,
      price: this.maxPrice,
      location: '',
    };

    this.filter();
  },
});
