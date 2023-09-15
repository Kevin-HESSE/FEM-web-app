import axios from 'axios';
import { getCurrentUser } from '@/services/page-context';

export function getBookmarkedVideo() {
  return axios(getCurrentUser());
}

/**
 *
 * @param email
 * @return {Promise<boolean>}
 */
export async function getUserByEmail(email) {
  const params = {
    email,
  };

  const response = await axios.get('/api/users', {
    params,
  });

  return response.data['hydra:totalItems'] === 1;
}
