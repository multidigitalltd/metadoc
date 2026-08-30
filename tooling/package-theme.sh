#!/usr/bin/env bash
# אריזת התבנית ל-ZIP מוכן להתקנה בוורדפרס
# (מראה ניהול → עיצוב → תבניות → הוספה → העלאת תבנית).
# שימוש: bash tooling/package-theme.sh
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DIR="$(basename "$ROOT")"
VERSION="$(grep -m1 '^Version:' "$ROOT/style.css" | sed 's/Version:[[:space:]]*//' | tr -d '\r')"
OUT="$ROOT/metadoc-${VERSION}.zip"

rm -f "$OUT"
# נארזים רק קבצי הפרודקשן: בלי git, בלי מקורות build ובלי חומרי עיון.
( cd "$ROOT/.." && zip -rq "$OUT" "$DIR" \
    -x "$DIR/.git/*" "$DIR/.git" \
       "$DIR/.github/*" \
       "$DIR/.gitignore" \
       "$DIR/tooling/*" \
       "$DIR/design-reference/*" \
       "$DIR/_lovable_src/*" \
       "$DIR/node_modules/*" \
       "$DIR/CLAUDE.md" \
       "$DIR/*.zip" \
       "$DIR/*.log" \
       "*.DS_Store" "*Thumbs.db" )

echo "$OUT"
du -h "$OUT"
unzip -l "$OUT" | tail -1
