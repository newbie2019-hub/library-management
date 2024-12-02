import type { HTMLAttributes } from "vue";

export type Sort = 'asc' | 'desc' | 'none'

export type TableFilters = {
  search: string;
  sort: { column: string, order: Sort };
  page: number
  per_page: number
}

export type TableHeaderEmit =
  | { type: 'visibility_change', value: 'hide' }
  | { type: 'sort', value: 'asc' | 'desc' }

export type TableItems = Record<string, any>[]

export type TableHeaders = {
  title: string;
  align?: 'start' | 'end' | 'center';
  class?: HTMLAttributes['class']
  sortable?: boolean
  key: string
  hideLabel?: boolean
  value?: string | ((item: any) => string | undefined)
}

export type PaginationConfig = {
  per_side: number
  total: number
}