import type { LatestIssuedBook, Member } from "@/@types/api/dashboard";
import type { TableHeaders } from "@/@types/components/data-table";
import { format } from 'date-fns'

export const headers: TableHeaders[] = [
  {
    title: 'Book',
    key: 'title',
    sortable: true,
    value: ({ book }: LatestIssuedBook) => book.title
  },
  {
    title: 'Librarian',
    sortable: true,
    key: 'librarian',
    value: ({ librarian }: LatestIssuedBook) => librarian.first_name + ' ' + librarian.last_name,
  },
  {
    title: 'Patron',
    sortable: true,
    key: 'patron',
    value: ({ member }: LatestIssuedBook) => member.first_name + ' ' + member.last_name
  },
  {
    title: 'Quantity',
    sortable: true,
    key: 'quantity'
  },
  {
    title: 'Date Issued',
    sortable: true,
    key: 'issued_at',
    value: ({ issued_at }: LatestIssuedBook) => format(issued_at, 'PPpp')
  },
  {
    title: 'Return Date',
    sortable: true,
    key: 'return_date',
    value: ({ return_date }: LatestIssuedBook) => format(return_date, 'PPpp')
  }
]