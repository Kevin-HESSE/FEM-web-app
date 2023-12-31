import { getCategories, getCurrentCategory } from '@/services/page-context';

/**
 * Define the main title of the video section based on different criteria. Use inside VideosPage
 * @name sectionTitleConstructor
 * @param videosList
 * @param searchTerm
 * @return {string}
 */
export function searchTitleConstructor(videosList, searchTerm) {
  if (window.location.pathname === '/bookmarks' && videosList.length === 0 && searchTerm === '') {
    return 'No bookmarked videos found. Visit different categories to add some.';
  }

  if (videosList.length === 0) {
    return 'Sorry, we found no videos !';
  }

  const wordResult = videosList.length === 1 ? 'result' : 'results';
  return `Found ${videosList.length} ${wordResult} for '${searchTerm}'`;
}

/**
 * Define the title of the videoList section inside CategoryPage.
 * @return {*}
 */
export function categoryTitleConstructor() {
  const categoryFound = getCategories().find(
    (category) => category.slug === getCurrentCategory(),
  );

  return categoryFound.name;
}
