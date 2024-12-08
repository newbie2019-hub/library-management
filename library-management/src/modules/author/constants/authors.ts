import type { Book } from "@/@types/api/books"
import type { RowAction, TableHeaders } from "@/@types/components/data-table"
import { format } from "date-fns"

const dateFormat = 'PPpp'

export const actions: RowAction = [
  {
    key: 'view',
    label: 'View Books',
    icon: 'mdi:arrow-top-right'
  },
  {
    key: 'update',
    label: 'Update',
    icon: 'mdi:pencil-outline'
  },
  {
    key: 'delete',
    label: 'Delete',
    icon: 'mdi:trash-outline'
  },
  {
    key: 'restore',
    label: 'Restore',
    icon: 'mdi:backup-restore'
  },
]

export const headers: TableHeaders[] = [
  {
    title: '#',
    key: 'id'
  },
  {
    title: 'Author',
    sortable: true,
    key: 'author',
    class: 'text-nowrap'
  },
  {
    title: 'No. of Books',
    sortable: true,
    key: 'books_count',
  },
  {
    title: 'Deleted At',
    sortable: true,
    key: 'deleted_at',
    class: 'text-nowrap',
    value: ({ deleted_at }: Book) => deleted_at ? format(deleted_at, dateFormat) : ''
  },
  {
    title: 'Options',
    key: 'options'
  }
]