export type CategoryFilterType = 'categorized' | 'uncategorized' | (string & {})
export type IncludedQtyType = 'out_of_stock' | 'all_books' | (string & {})

export type TableAction = 'update' | 'delete' | 'restore' | 'view';

export type BookFilters = {
  page: number;
  per_page: number;
  included_quantity?: IncludedQtyType
  include_record?: 'only_trashed' | 'with_trashed' | ''
  category?: CategoryFilterType
}