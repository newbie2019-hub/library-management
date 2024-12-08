export const LOADING = {
  //AUTHORS
  FETCH_AUTHORS: 'fetch_authors',
  DELETE_AUTHOR: 'delete_author',
  ADD_AUTHOR: 'add_author',
  UPDATE_AUTHOR: 'update_author',
  RESTORE_AUTHOR: 'restore_author',

  //BOOKS
  FETCH_BOOK: 'fetch_book',
  ADD_BOOK: 'add_book',
  DELETE_BOOK: 'delete_book',
  UPDATE_BOOK: 'update_book',
  REMOVE_BOOK: 'remove_book',
  RESTORE_BOOK: 'restore_book',
  BOOK_SUMMARY: 'book_summary',

  //CATEGORIES
  FETCH_CATEGORIES: 'fetch_category',
  ADD_CATEGORY: 'add_category',
  DELETE_CATEGORY: 'delete_category',
  UPDATE_CATEGORY: 'update_category',
  REMOVE_CATEGORY: 'remove_category',
  RESTORE_CATEGORY: 'restore_category',

  //MEMBERS

  //ISSUED BOOKS
  ISSUING_BOOK: 'issuing_book',
  FETCH_ISSUED: 'fetch_issued',
  UPDATE_ISSUED: 'update_issued',

  //RETURNED BOOKS

  //SETTINGS
  UPDATE_PHOTO: 'update_photo',
  UPDATE_ACCOUNT: 'update_account',
  UPDATE_INFO: 'update_info',
} as const;