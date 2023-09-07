import axios from 'axios';
import { getCurrentUser } from '@/services/page-context';

export function getBookmarkedVideo() {
  return axios(getCurrentUser());
}
