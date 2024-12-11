export {};

declare global {
  type objectType = { [key: string]: unknown }
  type ApiResponse<T> = {
    data: T
    message: string | null
  }
  //custom macro in laravel api
  type ApiSuccess<T> = {
    data: T;
    message: string
  }
  type PaginatedApiResponse<T> = {
    current_page: number;
    data: T;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: Link;
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: null;
    to: number;
    total: number
  }
  type Link = {
    url: null | string;
    label: string;
    active: boolean
  }
}