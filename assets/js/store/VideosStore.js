import { defineStore } from 'pinia';
import { getVideos } from '@/services/video-service';

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
    async fetchAllVideos() {
      const data = await getVideos(this.searchTerm);
      this.list = data.data['hydra:member'];
      this.isLoading = false;
    },
  },
});
