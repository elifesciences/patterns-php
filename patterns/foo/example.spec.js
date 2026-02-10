// @ts-check
import { test, expect } from "@playwright/test";

test("to have 0 failures", async ({ page }) => {
  await page.goto(
    "file:///Users/linakinduryte/patterns-php/patterns/test/authors.html",
  );

  const failureCountLocator = page.locator(".failures em");

  await expect(failureCountLocator).toHaveText("0");
});
