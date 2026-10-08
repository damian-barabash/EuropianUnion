import { site } from '../data/site'

// Working project logo: a rising chain of linked nodes (research moving towards investment)
// and the name. To be replaced if the project receives a designed logo.
export function Logo({ light = false }: { light?: boolean }) {
  return (
    <span className={`logo${light ? ' logo--light' : ''}`}>
      <svg className="logo__mark" viewBox="0 0 40 40" aria-hidden="true">
        <rect width="40" height="40" className="logo__tile" />
        <path d="M9.5 28.5 17 18l7.5 5.5L31 11" className="logo__link" />
        <circle cx="9.5" cy="28.5" r="3" className="logo__glyph" />
        <circle cx="17" cy="18" r="3" className="logo__glyph" />
        <circle cx="24.5" cy="23.5" r="3" className="logo__glyph" />
        <circle cx="31" cy="11" r="3.6" className="logo__dot" />
      </svg>
      <span className="logo__word">
        Trans<b>Bio</b>Net
      </span>
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
        {site.euLabel}
        <br />
        the European Union
      </span>
    </span>
  )
}
