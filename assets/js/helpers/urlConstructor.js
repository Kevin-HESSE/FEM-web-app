import { getCurrentCategory, getCurrentUser } from '@/services/page-context';

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
