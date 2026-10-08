import { site } from '../data/site'

// Project logo from the brand sheet (first of the three versions). `light` is the version
// for dark backgrounds: white lettering, the navy circle turned white.
export function Logo({ light = false }: { light?: boolean }) {
  const file = light ? 'logo-light.svg' : 'logo.svg'
  return <img className="logo" src={`${import.meta.env.BASE_URL}brand/${file}`} alt={site.name} width={150} height={54} />
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
