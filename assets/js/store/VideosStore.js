import { defineStore } from 'pinia';
import { getVideos, updateBookmark } from '@/services/video-service';

export const useVideoStore = defineStore('VideoStore', {
  state: () => ({
    list: [],
    searchTerm: '',
    isLoading: true,
  }),
  getters: {
    /**
     * Condition that allow to show the list of video
     * Used inside every page who show videos
     * @param state
     * @return {boolean}
     */
    showList: (state) => state.searchTerm === '' && !state.isLoading,
  },
  actions: {
    /**
     * Call the api to fill the list state
     * @return {Promise<void>}
     */
    async fetchAllVideos() {
      try {
        const data = await getVideos(this.searchTerm);
        this.list = data.data['hydra:member'];
        this.isLoading = false;
      } catch (e) {
        this.isLoading = false;
      }
    },
    /**
     * Handle the api call to update if the video is bookmarked or not
     * @param {String} method
     * @param {Number} id
     * @return {Promise<void>}
     */
    async removeFromBookmark(method, id) {
      try {
        await updateBookmark(method, id);
      } catch (e) {
        alert('An error has occurred, please try later.');
        return;
      }

      if (method === 'delete' && window.location.pathname === '/bookmarks') {
        for (let i = 0; i < this.list.length; i++) {
          if (this.list[i].id === id) {
            this.list.splice(i, 1);
          }
        }
      }
    },
  },
});
