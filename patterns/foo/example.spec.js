// @ts-check
import { test, expect } from "@playwright/test";
import fs from "fs";
import path from "path";

const testDir = path.resolve(__dirname, "../test");
const htmlFiles = fs.readdirSync(testDir).filter((f) => f.endsWith(".html"));

htmlFiles.forEach((file) =>
  test(`HTML failure tests for ${file}`, async ({ page }) => {
    const fileUrl = `file://${path.join(testDir, file)}`;
    await page.goto(fileUrl);
    const failureCountLocator = page.locator(".failures em");
    await expect(failureCountLocator).toHaveText("0");
  }),
);
