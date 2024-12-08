import type { HTMLAttributes } from "vue";
import type { TableAction } from "../table-filters";

export type RowAction = {
  label: string
  icon?: string
  key: TableAction
  shown?: Date | null
}[]

export type Sort = 'asc' | 'desc' | 'none'

export type TableFilters = {
  sort: { column: string, order: Sort };
  per_page: number
}

export type TableHeaderEmit =
  | { type: 'visibility_change', value: 'hide' }
  | { type: 'sort', value: 'asc' | 'desc' }

export type TableItems = Record<string, any>[]

export type TableHeaders = {
  title: string;
  rowClass?: HTMLAttributes['class']
  class?: HTMLAttributes['class']
  sortable?: boolean
  key: string
  hideLabel?: boolean
  value?: string | ((item: any) => string | undefined)
}

export type PaginationConfig = {
  per_side?: number
  total: number
}