import { getCategories, getCurrentCategory } from '@/services/page-context';

/**
 * Define the main title of the video section based on different criteria. Use inside VideosPage
 * @name sectionTitleConstructor
 * @param videosList
 * @param searchTerm
 * @return {string}
 */
export function sectionTitleConstructor(videosList, searchTerm) {
  if (videosList.length === 0) {
    return 'Sorry, we found no videos !';
  }

  if (searchTerm !== '') {
    const wordResult = videosList.length === 1 ? 'result' : 'results';
    return `Found ${videosList.length} ${wordResult} for '${searchTerm}'`;
  }

  if (getCurrentCategory() !== null) {
    const categoryFound = getCategories().find(
      (category) => category.slug === getCurrentCategory(),
    );

    return categoryFound.name;
  }

  if (window.location.pathname === '/bookmarks') {
    return 'Bookmarked videos';
  }

  return 'Recommended for you';
}
