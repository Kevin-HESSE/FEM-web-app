/**
 * Return the Iri of the User
 *
 * @return {string}
 */
export function getCurrentUser() {
  return window.currentUser;
}

export function getCategories() {
  return window.categories;
}

export function getCurrentCategory() {
  return window.currentCategory;
}

export function isDemo() {
  return window.demo === '1';
}
