import { useState } from 'react'
import { CtaBand, PageHero, SectionHead } from '../components/Blocks'
import { EuEmblem } from '../components/Brand'
import { Icon } from '../components/Icon'
import { team, timeline, workPackages } from '../data/content'
import { facts, lorem, pillars, site } from '../data/site'
import { img } from '../lib/format'

function Team() {
  const [i, setI] = useState(0)
  const p = team[i]
  const go = (step: number) => setI((i + step + team.length) % team.length)
  return (
    <div className="quote" data-reveal>
      <button className="quote__nav" onClick={() => go(-1)} aria-label="Previous person">
        <Icon name="arrow" />
      </button>
      <figure className="quote__box" aria-live="polite">
        <div className="quote__who">
          <img src={img(p.image)} alt="" width={160} height={160} />
          <figcaption>
            <strong>{p.name}</strong>
            {p.role}, {p.org}
          </figcaption>
        </div>
        <blockquote>{p.quote}</blockquote>
      </figure>
      <button className="quote__nav quote__nav--next" onClick={() => go(1)} aria-label="Next person">
        <Icon name="arrow" />
      </button>
    </div>
  )
}

export default function About() {
  return (
    <>
      <PageHero title="About the project" lead={lorem.short} crumbs={[{ label: 'About' }]} />

      <section className="section">
        <div className="container media">
          <img className="media__img" src={img('team-table.webp')} alt="Consortium members at a working meeting" width={700} height={500} loading="lazy" data-reveal />
          <div data-reveal>
            <h2>We are {site.name}</h2>
            <p>{lorem.p1}</p>
            <p>{lorem.p2}</p>
          </div>
        </div>
      </section>

      <section className="section section--grey">
        <div className="container">
          <SectionHead title="Objectives" text="What the project wants to achieve by its end." />
          <ul className="columns">
            {pillars.map((p) => (
              <li key={p.title} data-reveal>
                <h3>{p.title}</h3>
                <p>{p.text}</p>
              </li>
            ))}
          </ul>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <SectionHead title="Project timeline" />
          <ol className="timeline">
            {timeline.map((t) => (
              <li key={t.period} data-reveal>
                <span className="timeline__period">{t.period}</span>
                <h3>{t.title}</h3>
                <p>{t.text}</p>
              </li>
            ))}
          </ol>
        </div>
      </section>

      <section className="section section--grey">
        <div className="container media media--flip">
          <div data-reveal>
            <h2>How the work is organised</h2>
            <p>{lorem.p3}</p>
            <ul className="wp">
              {workPackages.map((w) => (
                <li key={w.code}>
                  <span>{w.code}</span>
                  {w.title}
                </li>
              ))}
            </ul>
          </div>
          <img className="media__img" src={img('students-library.webp')} alt="Researchers discussing results" width={700} height={500} loading="lazy" data-reveal />
        </div>
      </section>

      <section className="section">
        <div className="container">
          <SectionHead title="Introduction video" />
          <div className="video" data-reveal>
            <img src={img('audience.webp')} alt="" loading="lazy" />
            <button className="video__play" aria-label="Play the introduction video (placeholder)">
              <Icon name="play" size={34} />
            </button>
          </div>
        </div>
      </section>

      <section className="section section--grey">
        <div className="container">
          <SectionHead title="People behind the project" />
          <Team />
        </div>
      </section>

      <section className="section">
        <div className="container funding" data-reveal>
          <EuEmblem stacked />
          <div>
            <h2>Funding</h2>
            <p>
              {site.name} is co-funded by the European Union. {lorem.p2}
            </p>
            <dl className="facts facts--plain">
              {facts.map((f) => (
                <div key={f.label}>
                  <dt>{f.label}</dt>
                  <dd>{f.value}</dd>
                </div>
              ))}
            </dl>
            <p className="note">{site.grant}</p>
          </div>
        </div>
      </section>

      <CtaBand />
    </>
  )
}
