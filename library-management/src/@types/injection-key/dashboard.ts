import type { InjectionKey, Ref } from "vue";
import type { Dashboard } from "../api/dashboard";

export const dashboardKey =
  Symbol() as InjectionKey<Ref<Dashboard | null>>
