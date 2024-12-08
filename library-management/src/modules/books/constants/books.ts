import type { Book } from "@/@types/api/books"
import type { RowAction, TableHeaders } from "@/@types/components/data-table"
import { format } from "date-fns"

const dateFormat = 'PP' //No time i.e., April 29, 2004

export const actions: RowAction = [
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
    title: 'Book Cover',
    sortable: false,
    key: 'cover_photo',
    class: 'text-nowrap'
  },
  {
    title: 'Title',
    sortable: true,
    key: 'title',
  },
  {
    title: 'ISBN_No',
    sortable: true,
    key: 'isbn_no',
  },
  {
    title: 'Categories',
    key: 'categories'
  },
  {
    title: 'Author',
    sortable: true,
    key: 'author',
    value: ({ author }: Book) => author.author
  },
  {
    title: 'Quantity',
    sortable: true,
    key: 'quantity',
    rowClass: 'text-center',
    value: ({ quantity }: Book) => Intl.NumberFormat().format(+quantity)
  },
  {
    title: 'Price',
    sortable: true,
    key: 'price',
    rowClass: 'text-center',
    value: ({ price }: Book) => '₱ ' + Intl.NumberFormat().format(+price)
  },
  {
    title: 'Publisher',
    sortable: true,
    key: 'publisher',
  },
  {
    title: 'Edition',
    sortable: true,
    key: 'edition',
  },
  {
    title: 'Purchased Date',
    sortable: true,
    key: 'purchased_at',
    class: 'text-nowrap',
    value: ({ purchased_at }: Book) => purchased_at ? format(purchased_at, dateFormat) : ''
  },
  {
    title: 'Published Date',
    sortable: true,
    key: 'published_at',
    class: 'text-nowrap',
    value: ({ published_at }: Book) => published_at ? format(published_at, dateFormat) : ''
  },
  {
    title: 'Date Added',
    sortable: true,
    key: 'created_at',
    class: 'text-nowrap',
    value: ({ created_at }: Book) => format(created_at, 'PPpp')
  },
  {
    title: 'Deleted At',
    sortable: true,
    key: 'deleted_at',
    class: 'text-nowrap',
    value: ({ deleted_at }: Book) => deleted_at ? format(deleted_at, 'PPpp') : ''
  },
  {
    title: 'Options',
    key: 'options'
  }
]