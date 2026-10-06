import { useId, useState, type FormEvent, type ReactNode } from 'react'
import { Link } from 'react-router-dom'
import { site } from '../data/site'
import { Icon } from './Icon'

export function Breadcrumbs({ items }: { items: { label: string; to?: string }[] }) {
  return (
    <nav className="crumbs" aria-label="Breadcrumb">
      <ol>
        <li>
          <Link to="/">Home</Link>
        </li>
        {items.map((i) => (
          <li key={i.label} aria-current={i.to ? undefined : 'page'}>
            {i.to ? <Link to={i.to}>{i.label}</Link> : i.label}
          </li>
        ))}
      </ol>
    </nav>
  )
}

export function PageHero({ title, lead, crumbs, children }: { title: string; lead?: string; crumbs: { label: string; to?: string }[]; children?: ReactNode }) {
  return (
    <section className="pagehero">
      <div className="container pagehero__in">
        <Breadcrumbs items={crumbs} />
        <h1>{title}</h1>
        {lead && <p className="pagehero__lead">{lead}</p>}
        {children}
      </div>
    </section>
  )
}

export function SectionHead({ title, text, action }: { title: string; text?: string; action?: { label: string; to: string } }) {
  return (
    <div className="sechead" data-reveal>
      <div>
        <h2>{title}</h2>
        {text && <p>{text}</p>}
      </div>
      {action && (
        <Link className="btn btn--outline btn--sm" to={action.to}>
          {action.label}
        </Link>
      )}
    </div>
  )
}

export function Accordion({ items }: { items: { q: string; a: string }[] }) {
  const [open, setOpen] = useState<number | null>(0)
  const id = useId()
  return (
    <div className="acc">
      {items.map((it, i) => {
        const isOpen = open === i
        return (
          <div className={`acc__item${isOpen ? ' is-open' : ''}`} key={it.q}>
            <h3>
              <button id={`${id}-b${i}`} aria-expanded={isOpen} aria-controls={`${id}-p${i}`} onClick={() => setOpen(isOpen ? null : i)}>
                {it.q}
                <Icon name="chevron" />
              </button>
            </h3>
            <div id={`${id}-p${i}`} role="region" aria-labelledby={`${id}-b${i}`} className="acc__panel" hidden={!isOpen}>
              <p>{it.a}</p>
            </div>
          </div>
        )
      })}
    </div>
  )
}

export function Filter<T extends string>({ label, options, value, onChange }: { label: string; options: readonly T[]; value: T; onChange: (v: T) => void }) {
  return (
    <div className="filter" role="group" aria-label={label}>
      {options.map((o) => (
        <button key={o} className={`chip${o === value ? ' is-active' : ''}`} aria-pressed={o === value} onClick={() => onChange(o)}>
          {o}
        </button>
      ))}
    </div>
  )
}

// Test mode: nothing is sent yet. On WordPress this form is replaced by the theme's form handler.
export function ContactForm() {
  const [sent, setSent] = useState(false)
  const submit = (e: FormEvent) => {
    e.preventDefault()
    setSent(true)
  }
  if (sent) {
    return (
      <div className="form form--done" role="status">
        <h3>Message sent</h3>
        <p>Thank you. We will reply to the e-mail address you gave us.</p>
        <button className="btn btn--outline" onClick={() => setSent(false)}>
          Send another message
        </button>
      </div>
    )
  }
  return (
    <form className="form" onSubmit={submit}>
      <div className="form__row">
        <label>
          First name
          <input name="first_name" autoComplete="given-name" required />
        </label>
        <label>
          Last name
          <input name="last_name" autoComplete="family-name" required />
        </label>
      </div>
      <label>
        E-mail
        <input type="email" name="email" autoComplete="email" required />
      </label>
      <div className="form__row">
        <label>
          Type of organisation
          <select name="org_type" defaultValue="">
            <option value="" disabled>
              Choose one
            </option>
            {['Start-up', 'SME', 'Large company', 'University or research centre', 'Public body', 'Investor', 'Other'].map((o) => (
              <option key={o}>{o}</option>
            ))}
          </select>
        </label>
        <label>
          Topic
          <select name="topic" defaultValue="General question">
            {['General question', 'Open Calls', 'Partnership', 'Media', 'Digital Platform'].map((o) => (
              <option key={o}>{o}</option>
            ))}
          </select>
        </label>
      </div>
      <label>
        Message
        <textarea name="message" rows={5} required />
      </label>
      <label className="form__check">
        <input type="checkbox" name="privacy" required />
        <span>
          I have read the <Link to="/privacy-policy">privacy policy</Link> and agree to the processing of my data to answer this message.
        </span>
      </label>
      <label className="form__check">
        <input type="checkbox" name="newsletter" />
        <span>I would like to receive news about {site.name}.</span>
      </label>
      <button className="btn btn--primary" type="submit">
        Send message
      </button>
    </form>
  )
}

// "Let's talk" block: text on the left, form on the right. Closes the home page.
export function ContactBlock() {
  return (
    <section className="talk">
      <div className="container talk__in">
        <div className="talk__text" data-reveal>
          <h2>Let’s talk about the project</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          <p>
            Write to us at <a href={`mailto:${site.email}`}>{site.email}</a> or use the form.
          </p>
        </div>
        <div className="talk__form" data-reveal>
          <ContactForm />
        </div>
      </div>
    </section>
  )
}

export function CtaBand() {
  return (
    <section className="cta">
      <div className="container cta__in" data-reveal>
        <div>
          <h2>Have a question about the project?</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
        </div>
        <div className="cta__actions">
          <Link to="/contact" className="btn btn--light">
            Contact us
          </Link>
          <Link to="/open-calls" className="btn btn--outline-light">
            See Open Calls
          </Link>
        </div>
      </div>
    </section>
  )
}

export function Prose({ children }: { children: ReactNode }) {
  return <div className="prose">{children}</div>
}
