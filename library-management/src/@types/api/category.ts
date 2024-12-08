export type Categories = PaginatedApiResponse<Category[]>

export type Category = {
  id: string;
  category: string;
  deleted_at: Date | null;
  created_at: Date;
  updated_at: Date;
  books_count: number
}