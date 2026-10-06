import { site } from '../data/site'

// Placeholder project logo. The final logo comes from the project's graphic designer.
export function Logo({ light = false }: { light?: boolean }) {
  return (
    <span className={`logo${light ? ' logo--light' : ''}`}>
      <svg className="logo__mark" viewBox="0 0 40 40" aria-hidden="true">
        <rect width="40" height="40" className="logo__tile" />
        <path d="M20 8 31 31h-5.2l-2-4.6h-7.6l-2 4.6H9L20 8Zm0 9.6-2.3 5.2h4.6L20 17.6Z" className="logo__glyph" />
        <circle cx="20" cy="33.5" r="2.2" className="logo__dot" />
      </svg>
      <span className="logo__word">{site.name}</span>
    </span>
  )
}

const STAR = (() => {
  const pts: string[] = []
  for (let i = 0; i < 10; i++) {
    const r = i % 2 === 0 ? 1 : 0.382
    const a = (Math.PI / 5) * i - Math.PI / 2
    pts.push(`${(Math.cos(a) * r).toFixed(4)},${(Math.sin(a) * r).toFixed(4)}`)
  }
  return pts.join(' ')
})()

// European flag drawn to the official construction: 3:2 field, 12 upright stars on a circle
// with radius 1/3 of the flag height, star radius 1/18 of the height.
export function EuFlag() {
  const stars = Array.from({ length: 12 }, (_, i) => {
    const a = (Math.PI / 6) * i
    return { x: 45 + Math.sin(a) * 20, y: 30 - Math.cos(a) * 20 }
  })
  return (
    <svg className="eu__flag" viewBox="0 0 90 60" role="img" aria-label="Flag of the European Union">
      <rect width="90" height="60" fill="#003399" />
      {stars.map((s, i) => (
        <polygon key={i} points={STAR} fill="#FFCC00" transform={`translate(${s.x.toFixed(3)} ${s.y.toFixed(3)}) scale(3.333)`} />
      ))}
    </svg>
  )
}

export function EuEmblem({ light = false, stacked = false }: { light?: boolean; stacked?: boolean }) {
  return (
    <span className={`eu${light ? ' eu--light' : ''}${stacked ? ' eu--stacked' : ''}`}>
      <EuFlag />
      <span className="eu__text">
        Co-funded by
        <br />
        the European Union
      </span>
    </span>
  )
}
