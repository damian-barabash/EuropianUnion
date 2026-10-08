import { useState } from 'react'
import { Filter, PageHero, SectionHead } from '../components/Blocks'
import { ResourceRow } from '../components/Cards'
import { Icon } from '../components/Icon'
import { resources } from '../data/content'
import { img } from '../lib/format'

const types = ['All', 'Document', 'Deliverable', 'Promo material', 'Video'] as const

export default function Resources() {
  const [type, setType] = useState<(typeof types)[number]>('All')
  const list = resources.filter((r) => type === 'All' || r.type === type)
  const videos = resources.filter((r) => r.type === 'Video')
  return (
    <>
      <PageHero title="Resources" lead="Documents, public deliverables, promotional materials and videos produced by the project." crumbs={[{ label: 'Resources' }]} />
      <section className="section">
        <div className="container">
          <Filter label="Filter resources by type" options={types} value={type} onChange={setType} />
          {list.length ? (
            <ul className="docs">
              {list.map((r) => (
                <ResourceRow key={r.id} item={r} />
              ))}
            </ul>
          ) : (
            <p className="empty">Nothing in this category yet.</p>
          )}
        </div>
      </section>
      <section className="section section--grey">
        <div className="container">
          <SectionHead title="Videos" text="Recordings and short films about the project." />
          <div className="grid grid--2">
            {videos.map((v, i) => (
              <figure className="videocard" key={v.id} data-reveal>
                <div className="video">
                  <img src={img(i % 2 ? 'conference-blue.webp' : 'conference-audience.webp')} alt="" loading="lazy" />
                  <button className="video__play" aria-label={`Play: ${v.title} (placeholder)`}>
                    <Icon name="play" size={30} />
                  </button>
                </div>
                <figcaption>{v.title}</figcaption>
              </figure>
            ))}
          </div>
        </div>
      </section>
    </>
  )
}
