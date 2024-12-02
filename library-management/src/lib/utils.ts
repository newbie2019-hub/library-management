import { type ClassValue, clsx } from 'clsx'
import { twMerge } from 'tailwind-merge'
import { type DateValue } from '@internationalized/date'

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs))
}

export const formatDateIntl = (date: DateValue) => {
  const { year, month, day } = date;
  const dateObj = new Date(year, month - 1, day);
  return new Intl.DateTimeFormat('en-CA', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(dateObj);
};