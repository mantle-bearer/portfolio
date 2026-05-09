import type { Config, Context } from "@netlify/functions";
import { getUser } from "@netlify/identity";
import { db } from "../../db/index.js";
import { siteContent } from "../../db/schema.js";
import { eq } from "drizzle-orm";

export default async (req: Request, context: Context) => {
  if (req.method === "GET") {
    try {
      const allContent = await db.select().from(siteContent);
      // convert [{key, value}] to {key: value}
      const contentMap = allContent.reduce((acc, curr) => {
        acc[curr.key] = curr.value;
        return acc;
      }, {} as Record<string, string>);
      return Response.json(contentMap);
    } catch (e: any) {
      console.error(e);
      return new Response("Internal Server Error", { status: 500 });
    }
  }

  if (req.method === "PUT") {
    // Check auth
    const user = await getUser();
    if (!user) {
      return new Response("Unauthorized", { status: 401 });
    }

    try {
      const payload = await req.json();
      
      // The payload should be an object of key/value pairs
      if (typeof payload !== "object" || payload === null) {
        return new Response("Bad Request", { status: 400 });
      }

      // We'll update or insert each key
      for (const [key, value] of Object.entries(payload)) {
        if (typeof value === "string") {
          // Check if exists
          const existing = await db.select().from(siteContent).where(eq(siteContent.key, key));
          if (existing.length > 0) {
            await db.update(siteContent).set({ value }).where(eq(siteContent.key, key));
          } else {
            await db.insert(siteContent).values({ key, value });
          }
        }
      }

      return Response.json({ success: true });
    } catch (e: any) {
      console.error(e);
      return new Response("Internal Server Error", { status: 500 });
    }
  }

  return new Response("Method not allowed", { status: 405 });
};

export const config: Config = {
  path: "/api/content",
};