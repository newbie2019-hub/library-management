import type { InjectionKey, Ref } from "vue";
import type { User } from "../api/user";

export const userKey = Symbol() as InjectionKey<Ref<User>>
