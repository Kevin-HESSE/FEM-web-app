import axios from 'axios';
import { getCurrentUser } from '@/services/page-context';
import { urlConstructor } from '@/helpers/urlConstructor';

/**
 * Return all videos based on the parameters
 * @param {String|null} searchTerm
 * @return {Promise<axios.AxiosResponse<any>> | *}
 */
export function getVideos(searchTerm) {
  const params = {};

  const url = urlConstructor();

  if (searchTerm) {
    params.title = searchTerm;
  }

  return axios.get(url, {
    params,
  });
}

export function updateBookmark(method, videoId) {
  if (method === 'post') {
    return axios.post(`/api/videos/${videoId}/bookmark`, {
      users: [
        `${getCurrentUser()}`,
      ],
    });
  }

  if (method === 'delete') {
    return axios.delete(`/api/videos/${videoId}/bookmark`);
  }

  return console.error('You must set "post" or "delete" method');
}
