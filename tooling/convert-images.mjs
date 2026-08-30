/**
 * המרת תמונות התוכן ל-WebP (תקן הביצועים של Multi Digital).
 * סורק את assets/img ואת תיקיות המשנה שלה.
 * שימוש: npm run images
 */
import sharp from 'sharp';
import { readdir } from 'node:fs/promises';

const root = new URL('../assets/img/', import.meta.url);

async function walk(dir) {
	const entries = await readdir(dir, { withFileTypes: true });
	for (const entry of entries) {
		if (entry.isDirectory()) {
			await walk(new URL(entry.name + '/', dir));
			continue;
		}
		if (!/\.(jpe?g|png)$/i.test(entry.name)) { continue; }
		const src = new URL(entry.name, dir);
		const out = new URL(entry.name.replace(/\.(jpe?g|png)$/i, '.webp'), dir);
		const info = await sharp(src.pathname).webp({ quality: 82 }).toFile(out.pathname);
		console.log(`${src.pathname.split('/assets/img/')[1]} -> ${Math.round(info.size / 1024)}KB`);
	}
}

await walk(root);
