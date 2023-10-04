/**
 * Return the Iri of the User
 *
 * @return {string}
 */
export function getCurrentUser() {
  return window.currentUser;
}

/**
 * Return the list of all categories passed by twig
 * @return {Object[]}
 */
export function getCategories() {
  return window.categories;
}

/**
 * Return the current category slug passed by twig
 * @return {null|string}
 */
export function getCurrentCategory() {
  return window.currentCategory;
}

/**
 * Return the status of the application if it is under demo mode or not
 * @return {boolean}
 */
export function isDemo() {
  return window.demo === '1';
}
