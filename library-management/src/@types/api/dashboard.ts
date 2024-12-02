export type Dashboard = {
  book_count: number;
  issued_book_count: number;
  author_count: number;
  categories_count: number;
  overdue: {
    books: Overdue[],
    total_count: number
  };
  latest_issued_books: LatestIssuedBook[];
  chartData: ChartData[]
}

export type ChartData = {
  issued_date: Date;
  total_quantity: string;
}

export type Overdue = {
  id: string;
  book_id: string;
  user_id: string;
  member_id: string;
  quantity: number;
  return_date: Date;
  issued_at: Date;
  deleted_at: null;
  created_at: Date;
  updated_at: Date;
  book:Book;
  member: Librarian;
  librarian: Librarian;
}

export interface LatestIssuedBook {
  id: string;
  book_id: string;
  user_id: string;
  member_id: string;
  quantity: number;
  book: Book;
  member: Member;
  librarian: Librarian;
  issued_at: Date;
  return_date: Date;
  deleted_at: null;
  created_at: Date;
  updated_at: Date;
}

export interface Book {
  id: string;
  title: string;
  cover_photo: string;
}

export interface Librarian {
  id: string;
  first_name: string;
  last_name: string;
  profile_photo: null;
}

export interface Member {
  id: string;
  first_name: string;
  last_name: string;
  profile_photo: null;
}