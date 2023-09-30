/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
// Import Swiper styles
import 'swiper/css';

import 'swiper/css/free-mode';

const app = {
  init: () => {
    const bookmarks = document.querySelectorAll('.thumbnail__bookmark');

    for (const bookmark of bookmarks) {
      bookmark.addEventListener('click', app.bookmarkAction);
    }
  },
  bookmarkAction: (event) => {
    let isBookmarked = (/true/i).test(event.target.dataset.filmBookmark);

    const filmInformation = { id: event.target.dataset.filmId, isBookmarked };

    try {
      fetch('/user/action/bookmark', {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(filmInformation),
      }).then((response) => {
        if (response.status === 200) {
          isBookmarked = !isBookmarked;
          event.target.dataset.filmBookmark = isBookmarked;
          isBookmarked ? event.target.classList.add('is-active') : event.target.classList.remove('is-active');

          if (window.location.pathname === '/bookmarks' && !isBookmarked) {
            event.target.parentNode.remove();
          }
        }
      });
    } catch (error) {
      console.error('An error has occurred !');
    }
  },

};

document.addEventListener('DOMContentLoaded', app.init);
