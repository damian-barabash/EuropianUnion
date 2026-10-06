import { PageHero } from '../components/Blocks'
import { lorem } from '../data/site'

const sections = ['Lorem ipsum dolor sit amet', 'Consectetur adipiscing elit', 'Sed do eiusmod tempor', 'Ut labore et dolore magna', 'Contact']

export default function Legal({ title }: { title: string }) {
  return (
    <>
      <PageHero title={title} lead="Placeholder text. The final wording will be provided by the project team." crumbs={[{ label: title }]} />
      <section className="section">
        <div className="container article">
          <div className="prose">
            {sections.map((s, i) => (
              <div key={s}>
                <h2>
                  {i + 1}. {s}
                </h2>
                <p>{lorem.p1}</p>
                <p>{lorem.p2}</p>
              </div>
            ))}
          </div>
        </div>
      </section>
    </>
  )
}
