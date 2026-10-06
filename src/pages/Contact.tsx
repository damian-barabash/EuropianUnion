import { ContactForm, PageHero } from '../components/Blocks'
import { Icon } from '../components/Icon'
import { site } from '../data/site'

export default function Contact() {
  return (
    <>
      <PageHero title="Contact" lead="Write to the project team. We usually reply within a few working days." crumbs={[{ label: 'Contact' }]} />
      <section className="section">
        <div className="container contact">
          <div>
            <h2>Project office</h2>
            <ul className="contact__list">
              <li>
                <Icon name="mail" />
                <a href={`mailto:${site.email}`}>{site.email}</a>
              </li>
              <li>
                <Icon name="phone" />
                <a href={`tel:${site.phone.replace(/\s/g, '')}`}>{site.phone}</a>
              </li>
              <li>
                <Icon name="pin" />
                <span>{site.address}</span>
              </li>
            </ul>
            <h2>Media and press</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. For press enquiries write to <a href="mailto:press@example.eu">press@example.eu</a>.</p>
            <h2>Follow the project</h2>
            <ul className="contact__social">
              {site.social.map((s) => (
                <li key={s.label}>
                  <a href={s.href}>{s.label}</a>
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
