import * as z from "zod";
import type { userSchema } from "../schema/user-details";

export type User = z.infer<typeof userSchema>