/**
 * המרת קבצי .woff שבתיקיית assets/fonts ל-.woff2 (קטן יותר, ומונע בקשת 404
 * מיותרת — ה-CSS מבקש woff2 ראשון). שימוש: npm run fonts
 */
import { readdir, readFile, writeFile } from 'node:fs/promises';
import { inflateSync } from 'node:zlib';
import { compress } from 'wawoff2';

const dir = new URL('../assets/fonts/', import.meta.url);

/** מפרק WOFF חזרה ל-sfnt (TTF/OTF) לפי מפרט W3C WOFF 1.0. */
function woffToSfnt(buf) {
	if (buf.toString('latin1', 0, 4) !== 'wOFF') { throw new Error('not a WOFF file'); }
	const flavor = buf.readUInt32BE(4);
	const numTables = buf.readUInt16BE(12);

	const entries = [];
	for (let i = 0; i < numTables; i++) {
		const p = 44 + i * 20;
		entries.push({
			tag: buf.subarray(p, p + 4),
			offset: buf.readUInt32BE(p + 4),
			compLength: buf.readUInt32BE(p + 8),
			origLength: buf.readUInt32BE(p + 12),
			checksum: buf.readUInt32BE(p + 16),
		});
	}

	const pad = (n) => (n + 3) & ~3;
	let dataSize = 0;
	for (const e of entries) { dataSize += pad(e.origLength); }

	const out = Buffer.alloc(12 + numTables * 16 + dataSize);
	let maxPow = 1;
	while (maxPow * 2 <= numTables) { maxPow *= 2; }
	out.writeUInt32BE(flavor, 0);
	out.writeUInt16BE(numTables, 4);
	out.writeUInt16BE(maxPow * 16, 6);
	out.writeUInt16BE(Math.log2(maxPow), 8);
	out.writeUInt16BE(numTables * 16 - maxPow * 16, 10);

	let cursor = 12 + numTables * 16;
	entries.forEach((e, i) => {
		const raw = buf.subarray(e.offset, e.offset + e.compLength);
		const data = e.compLength === e.origLength ? raw : inflateSync(raw);
		if (data.length !== e.origLength) { throw new Error('table length mismatch'); }
		const d = 12 + i * 16;
		e.tag.copy(out, d);
		out.writeUInt32BE(e.checksum, d + 4);
		out.writeUInt32BE(cursor, d + 8);
		out.writeUInt32BE(e.origLength, d + 12);
		data.copy(out, cursor);
		cursor += pad(e.origLength);
	});

	return out;
}

const files = (await readdir(dir)).filter((f) => f.endsWith('.woff'));
for (const f of files) {
	const woff = await readFile(new URL(f, dir));
	const woff2 = Buffer.from(await compress(woffToSfnt(woff)));
	const out = f.replace(/\.woff$/, '.woff2');
	await writeFile(new URL(out, dir), woff2);
	console.log(`${f} ${Math.round(woff.length / 1024)}KB -> ${out} ${Math.round(woff2.length / 1024)}KB`);
}
