export type BookAction = 'update' | 'delete' | 'restore'

export type Authors = PaginatedApiResponse<Author[]>

export type Author = {
  id: string;
  author: string;
}