export type CategoryFilterType = 'categorized' | 'uncategorized' | (string & {})
export type IncludedQtyType = 'out_of_stock' | 'all_books' | (string & {})

export type BookFilters = {
  search?: string;
  page: number;
  per_page?: number;
  included_quantity?: IncludedQtyType
  include_record?: 'deleted_only' | 'undeleted_only' | 'with_deleted'
  category?: CategoryFilterType
}