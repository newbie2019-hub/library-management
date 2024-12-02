export type BookSummary = {
  total_books: number
  uncategorized: number
  unreturnedBooks: number
  categories_count: number
}

export type Books = PaginatedApiResponse<Book[]>

export type Book = {
  id: string;
  author_id: string;
  isbn_no: string;
  title: string;
  quantity: number;
  edition: null;
  price: string;
  pages: number;
  publisher:    null;
  series: null;
  cover_photo: null;
  published_at: null;
  purchased_at: null;
  deleted_at: null;
  created_at: Date;
  updated_at: Date;
  categories: Category[];
  author: Author;
}

export type Author = {
  id: string;
  author: string;
  deleted_at: null;
  created_at: Date;
  updated_at: Date;
}

export type Category = {
  id: string;
  category: string;
}