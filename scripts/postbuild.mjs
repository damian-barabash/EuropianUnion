// GitHub Pages serves a real file with HTTP 200 only if it exists, so every route gets its own
// copy of index.html. 404.html covers anything not listed here.
import { copyFileSync, mkdirSync, readFileSync } from 'node:fs'
import { dirname, join } from 'node:path'

const dist = 'dist'
const content = readFileSync('src/data/content.ts', 'utf8')
const slugsOf = (name) => {
  const block = content.match(new RegExp(`export const ${name}:[^=]*= \\[([\\s\\S]*?)\\n\\]`))?.[1] ?? ''
  return [...block.matchAll(/slug: '([^']+)'/g)].map((m) => m[1])
}

const routes = [
  'about', 'open-calls', 'partners', 'news', 'events', 'resources', 'digital-platform', 'contact',
  'privacy-policy', 'cookie-policy', 'accessibility',
  ...slugsOf('calls').map((s) => `open-calls/${s}`),
  ...slugsOf('partners').map((s) => `partners/${s}`),
  ...slugsOf('posts').map((s) => `news/${s}`),
  ...slugsOf('events').map((s) => `events/${s}`),
]

for (const r of routes) {
  const file = join(dist, r, 'index.html')
  mkdirSync(dirname(file), { recursive: true })
  copyFileSync(join(dist, 'index.html'), file)
}
copyFileSync(join(dist, 'index.html'), join(dist, '404.html'))
console.log(`postbuild: ${routes.length} route pages + 404.html`)
