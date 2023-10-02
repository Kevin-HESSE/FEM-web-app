import axios from 'axios';
import { getCurrentUser } from '@/services/page-context';

export async function getUserInfo() {
  const response = await axios(getCurrentUser());

  return response.data;
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

export async function updatedPassword(password) {
  try {
    return await axios.patch(getCurrentUser(), {
      password,
    }, {
      headers: {
        'Content-Type': 'application/merge-patch+json',
      },
    });
  } catch (e) {
    console.log(e);
  }
}
