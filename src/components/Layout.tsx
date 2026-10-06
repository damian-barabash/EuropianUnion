import { useEffect, useState } from 'react'
import { Link, NavLink, Outlet, useLocation } from 'react-router-dom'
import { footerMenu, legalMenu, mainMenu, site } from '../data/site'
import { useReveal } from '../lib/useReveal'
import { EuEmblem, Logo } from './Brand'
import { Icon } from './Icon'

function Announcement() {
  const a = site.announcement
  if (!a.text) return null
  return (
    <div className="announce">
      <div className="container announce__in">
        <span>{a.text}</span>
        <Link to={a.to}>{a.linkLabel}</Link>
      </div>
    </div>
  )
}

function Header() {
  const [open, setOpen] = useState(false)
  const { pathname } = useLocation()
  useEffect(() => setOpen(false), [pathname])
  useEffect(() => {
    document.body.classList.toggle('nav-open', open)
    const onKey = (e: KeyboardEvent) => e.key === 'Escape' && setOpen(false)
    window.addEventListener('keydown', onKey)
    return () => window.removeEventListener('keydown', onKey)
  }, [open])

  return (
    <header className="header">
      <div className="container header__in">
        <div className="header__brand">
          <Link to="/" aria-label={`${site.name} — home`}>
            <Logo />
          </Link>
          <span className="header__sep" aria-hidden="true" />
          <EuEmblem />
        </div>

        <button className="header__burger" aria-expanded={open} aria-controls="main-nav" onClick={() => setOpen(!open)}>
          <Icon name={open ? 'close' : 'menu'} size={24} />
          <span className="sr-only">{open ? 'Close menu' : 'Open menu'}</span>
        </button>

        <nav id="main-nav" className={`nav${open ? ' is-open' : ''}`} aria-label="Main">
          <ul className="nav__list">
            {mainMenu.map((item) => (
              <li key={item.label} className={item.children ? 'nav__item nav__item--parent' : 'nav__item'}>
                <NavLink to={item.to} className="nav__link">
                  {item.label}
                  {item.children && <Icon name="chevron" size={16} />}
                </NavLink>
                {item.children && (
                  <ul className="nav__sub">
                    {item.children.map((c) => (
                      <li key={c.to}>
                        <NavLink to={c.to} className="nav__sublink">
                          {c.label}
                        </NavLink>
                      </li>
                    ))}
                  </ul>
                )}
              </li>
            ))}
          </ul>
        </nav>
      </div>
    </header>
  )
}

function Footer() {
  return (
    <footer className="footer">
      <div className="container footer__top">
        <div className="footer__brand">
          <Logo light />
          <p>{site.tagline}. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
          <ul className="footer__social">
            {site.social.map((s) => (
              <li key={s.label}>
                <a href={s.href}>{s.label}</a>
              </li>
            ))}
          </ul>
        </div>
        <nav aria-label="Footer">
          <h2 className="footer__h">Explore</h2>
          <ul className="footer__menu">
            {footerMenu.map((m) => (
              <li key={m.to}>
                <Link to={m.to}>{m.label}</Link>
              </li>
            ))}
          </ul>
        </nav>
        <div>
          <h2 className="footer__h">Contact</h2>
          <address className="footer__contact">
            <a href={`mailto:${site.email}`}>{site.email}</a>
            <a href={`tel:${site.phone.replace(/\s/g, '')}`}>{site.phone}</a>
            <span>{site.address}</span>
          </address>
        </div>
      </div>

      <div className="container">
        <div className="footer__eu">
          <EuEmblem light />
          <p>
            {site.disclaimer} <span className="footer__grant">{site.grant}</span>
          </p>
        </div>
      </div>

      <div className="container footer__bottom">
        <span>
          © {new Date().getFullYear()} {site.name}
        </span>
        <ul>
          {legalMenu.map((m) => (
            <li key={m.to}>
              <Link to={m.to}>{m.label}</Link>
            </li>
          ))}
        </ul>
      </div>
    </footer>
  )
}

const COOKIE_KEY = 'cookie-consent'

function CookieBanner() {
  const [visible, setVisible] = useState(false)
  useEffect(() => {
    try {
      setVisible(!localStorage.getItem(COOKIE_KEY))
    } catch {
      setVisible(true)
    }
  }, [])
  if (!visible) return null
  const choose = (value: 'all' | 'necessary') => {
    try {
      localStorage.setItem(COOKIE_KEY, value)
    } catch {
      /* storage unavailable: the banner returns on the next visit */
    }
    setVisible(false)
  }
  return (
    <div className="cookie" role="dialog" aria-labelledby="cookie-title" aria-describedby="cookie-text">
      <h2 id="cookie-title">We use cookies</h2>
      <p id="cookie-text">
        Necessary cookies keep the site working. With your consent we also use analytics cookies to improve it. Read the{' '}
        <Link to="/cookie-policy">cookie policy</Link>.
      </p>
      <div className="cookie__actions">
        <button className="btn btn--primary btn--sm" onClick={() => choose('all')}>
          Accept all
        </button>
        <button className="btn btn--outline btn--sm" onClick={() => choose('necessary')}>
          Only necessary
        </button>
      </div>
    </div>
  )
}

export function Layout() {
  useReveal()
  return (
    <>
      <a className="skip" href="#main">
        Skip to content
      </a>
      <Announcement />
      <Header />
      <main id="main">
        <Outlet />
      </main>
      <Footer />
      <CookieBanner />
    </>
  )
}
