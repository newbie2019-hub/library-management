import { ROUTE } from "@/@types/routes";
import type { RouteLocationRaw } from "vue-router";

type Routes = {
  label: string;
  icon: string;
  path: RouteLocationRaw
}

export const routes: Routes[] = [
  {
    label: 'Dashboard',
    icon: 'mdi:chart-bell-curve-cumulative',
    path: { name: ROUTE.DASHBOARD }
  },
  {
    label: 'Books',
    icon: 'mdi:book-heart-outline',
    path: { name: ROUTE.MANAGE_BOOKS }
  },
  {
    label: 'Categories',
    icon: 'mdi:bookmark-multiple-outline',
    path: { name: ROUTE.CATEGORIES }
  },
  {
    label: 'Members',
    icon: 'mdi:user-group-outline',
    path: { name: ROUTE.MEMBERS }
  },
  {
    label: 'Authors',
    icon: 'mdi:user-heart-outline',
    path: { name: ROUTE.AUTHORS }
  },
  {
    label: 'Issued Books',
    icon: 'mdi:book-clock-outline',
    path: { name: ROUTE.BORROWED_BOOKS }
  },
  {
    label: 'Returned Books',
    icon: 'mdi:book-clock-outline',
    path: { name: ROUTE.RETURNED_BOOKS }
  },
  {
    label: 'Settings',
    icon: 'mdi:cog-outline',
    path: { name: ROUTE.SETTINGS }
  },
]