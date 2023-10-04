import { getCurrentCategory, getCurrentUser } from '@/services/page-context';

/**
 * Return the correct url based on variable passed by twig.
 * @return {string}
 */
export function urlConstructor() {
  let url = '/api/videos?page=1';

  if (getCurrentCategory() !== null) {
    url += `&category.slug=${getCurrentCategory()}`;
  }

  if (window.isBookmarked) {
    url += `&users=${getCurrentUser()}`;
  }

  return url;
}
