import axios from 'axios';

/**
 * Return all videos based on the parameters
 * @param {String|null} searchTerm
 * @return {Promise<axios.AxiosResponse<any>> | *}
 */
export function getVideos(searchTerm) {
  const params = {};

  if (searchTerm) {
    params.title = searchTerm;
  }

  return axios.get('/api/videos?page=1', {
    params,
  });
}
