import axios from 'axios';

export function getVideos() {
  return axios('/api/videos?page=1');
}
