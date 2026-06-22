/**
 * המרת תמונות התוכן ל-WebP (תקן הביצועים של Multi Digital).
 * שימוש: npm run images
 */
import sharp from 'sharp';
import { readdir } from 'node:fs/promises';

const dir = new URL('../assets/img/', import.meta.url);
const files = (await readdir(dir)).filter((f) => /\.(jpe?g|png)$/i.test(f));

for (const f of files) {
	const src = new URL(f, dir);
	const out = new URL(f.replace(/\.(jpe?g|png)$/i, '.webp'), dir);
	const info = await sharp(src.pathname).webp({ quality: 82 }).toFile(out.pathname);
	console.log(`${f} -> ${Math.round(info.size / 1024)}KB`);
}
