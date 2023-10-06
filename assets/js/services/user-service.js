import axios from 'axios';
import { getCurrentUser } from '@/services/page-context';

/**
 * Retrieve all user info from the database except the password.
 * @return {Promise<any>}
 */
export async function getUserInfo() {
  const response = await axios(getCurrentUser());

  return response.data;
}

/**
 * Verify if the email already exist in the server.
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

/**
 * Update the password of the current user.
 * @param {String} password
 * @return {Promise<axios.AxiosResponse<any>>}
 */
export async function updatedPassword(password) {
  return axios.patch(getCurrentUser(), {
    password,
  }, {
    headers: {
      'Content-Type': 'application/merge-patch+json',
    },
  });
}

/**
 * Request the api to create the user
 * @param userData
 * @return {Promise<axios.AxiosResponse<any>>}
 */
export async function createUser(userData) {
  return axios.post('/api/users', {
    email: userData.email,
    username: userData.username,
    password: userData.plainPassword,
  });
}

/**
 * Request the server with fetch to log in the user.
 * @param userData
 * @return {Promise<Response>}
 */
export async function loginUser(userData) {
  return fetch('/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(userData),
  });
}
