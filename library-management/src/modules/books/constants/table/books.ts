import type { Book } from "@/@types/api/books"
import type { TableHeaders } from "@/@types/components/data-table"
import { format } from "date-fns"

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
    title: 'Quantity',
    sortable: true,
    key: 'quantity',
  },
  {
    title: 'Date Added',
    sortable: true,
    key: 'created_at',
    class: 'text-nowrap',
    value: ({ created_at }: Book) => format(created_at, 'PPpp')
  },
  {
    title: 'Options',
    key: 'options'
  }
]