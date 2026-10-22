import { ContactForm, PageHero } from '../components/Blocks'
import { Icon } from '../components/Icon'
import { site } from '../data/site'

export default function Contact() {
  return (
    <>
      <PageHero title="Contact" crumbs={[{ label: 'Contact' }]} />
      <section className="section">
        <div className="container contact">
          <div>
            <h2>Contact</h2>
            <ul className="contact__list">
              <li>
                <Icon name="mail" />
                <a href={`mailto:${site.email}`}>{site.email}</a>
              </li>
            </ul>
            <h2>Follow the project</h2>
            <ul className="contact__social">
              {site.social.map((s) => (
                <li key={s.label}>
                  {s.href ? (
                    <a href={s.href} target="_blank" rel="noopener noreferrer">
                      {s.label}
                    </a>
                  ) : (
                    <span>{s.label}</span>
                  )}
                </li>
              ))}
            </ul>
          </div>
          <div className="contact__form">
            <h2>Send a message</h2>
            <ContactForm />
          </div>
        </div>
      </section>
    </>
  )
}
