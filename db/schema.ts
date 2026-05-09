import { pgTable, text } from "drizzle-orm/pg-core";

export const siteContent = pgTable("site_content", {
  key: text("key").primaryKey(),
  value: text("value").notNull(),
});
