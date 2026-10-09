import { useRef } from 'react'
import { site } from '../data/site'
import { logoSrc, logoVariants, setLogo, useLogo } from '../lib/logoChoice'

// Project logo from the brand sheet. Which of the three versions is shown is chosen in the footer
// (see LogoSwitcher). `light` is the version for dark backgrounds: white instead of navy.
export function Logo({ light = false }: { light?: boolean }) {
  const id = useLogo()
  const v = logoVariants.find((x) => x.id === id) ?? logoVariants[0]
  return <img className={`logo logo--v${v.id}`} src={logoSrc(v.id, light)} alt={site.name} width={Math.round(v.height * v.ratio)} height={v.height} />
}

// Small link in the footer that opens a window with the three logo versions.
export function LogoSwitcher() {
  const id = useLogo()
  const ref = useRef<HTMLDialogElement>(null)
  return (
    <>
      <button className="logopick__open" onClick={() => ref.current?.showModal()}>
        Zmień logo
      </button>
      <dialog className="logopick" ref={ref} aria-labelledby="logopick-title" onClick={(e) => e.target === ref.current && ref.current?.close()}>
        <div className="logopick__in">
          <h2 id="logopick-title">Wybierz logo</h2>
          <p>Wybrana wersja pokaże się na całej stronie. Wybór zapisuje się tylko w tej przeglądarce.</p>
          <ul>
            {logoVariants.map((v) => (
              <li key={v.id}>
                <button
                  className={`logopick__item${v.id === id ? ' is-active' : ''}`}
                  aria-pressed={v.id === id}
                  onClick={() => {
                    setLogo(v.id)
                    ref.current?.close()
                  }}
                >
                  <img src={logoSrc(v.id)} alt={`Logo ${site.name}, ${v.label.toLowerCase()}`} />
                  <span>{v.id === id ? `${v.label} · wybrana` : v.label}</span>
                </button>
              </li>
            ))}
          </ul>
          <button className="btn btn--outline btn--sm" onClick={() => ref.current?.close()}>
            Zamknij
          </button>
        </div>
      </dialog>
    </>
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
