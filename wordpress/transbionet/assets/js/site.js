// TransBioNet theme: small, independent behaviours. No libraries.
(() => {
  const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel))

  /* Mobile menu */
  const burger = document.querySelector('.header__burger')
  const nav = document.getElementById('main-nav')
  if (burger && nav) {
    const setOpen = (open) => {
      burger.setAttribute('aria-expanded', String(open))
      nav.classList.toggle('is-open', open)
      document.body.classList.toggle('nav-open', open)
    }
    burger.addEventListener('click', () => setOpen(burger.getAttribute('aria-expanded') !== 'true'))
    document.addEventListener('keydown', (e) => e.key === 'Escape' && setOpen(false))
    matchMedia('(min-width: 1141px)').addEventListener('change', (e) => e.matches && setOpen(false))
  }

  /* Blocks appear on scroll. Hidden only when this script runs, so nothing stays invisible without JS. */
  const reveal = $$('[data-reveal]')
  if (!('IntersectionObserver' in window) || matchMedia('(prefers-reduced-motion: reduce)').matches) {
    reveal.forEach((el) => el.classList.add('is-in'))
  } else {
    document.documentElement.classList.add('reveal-ready')
    const io = new IntersectionObserver(
      (entries) => {
        for (const e of entries) {
          if (e.isIntersecting) {
            e.target.classList.add('is-in')
            io.unobserve(e.target)
          }
        }
      },
      { rootMargin: '0px 0px -8% 0px', threshold: 0.08 },
    )
    reveal.forEach((el) => io.observe(el))
  }

  /* Questions and answers: one open at a time */
  $$('.acc').forEach((acc) => {
    acc.addEventListener('click', (e) => {
      const btn = e.target.closest('button[aria-controls]')
      if (!btn) return
      const open = btn.getAttribute('aria-expanded') !== 'true'
      $$('.acc__item', acc).forEach((item) => {
        const b = item.querySelector('button[aria-controls]')
        const isThis = b === btn && open
        b.setAttribute('aria-expanded', String(isThis))
        item.classList.toggle('is-open', isThis)
        document.getElementById(b.getAttribute('aria-controls')).hidden = !isThis
      })
    })
  })

  /* Resource type filter */
  $$('[data-filter-scope]').forEach((scope) => {
    const chips = $$('[data-filter]', scope)
    chips.forEach((chip) =>
      chip.addEventListener('click', () => {
        const type = chip.dataset.filter
        chips.forEach((c) => {
          c.classList.toggle('is-active', c === chip)
          c.setAttribute('aria-pressed', String(c === chip))
        })
        $$('.doc', scope).forEach((doc) => {
          doc.hidden = !!type && !(doc.dataset.types || '').split(' ').includes(type)
        })
      }),
    )
  })

  /* People with quotes: arrows switch the person */
  $$('[data-quotes]').forEach((box) => {
    const items = $$('.quote__box', box)
    let i = 0
    $$('[data-step]', box).forEach((btn) =>
      btn.addEventListener('click', () => {
        items[i].hidden = true
        i = (i + Number(btn.dataset.step) + items.length) % items.length
        items[i].hidden = false
      }),
    )
  })

  /* Video: the player (and its cookies) loads only after a click */
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.video[data-embed] .video__play')
    if (!btn) return
    const box = btn.closest('.video')
    const frame = document.createElement('iframe')
    frame.src = box.dataset.embed
    frame.title = btn.getAttribute('aria-label') || 'Video'
    frame.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen'
    frame.allowFullscreen = true
    box.replaceChildren(frame)
    box.classList.add('is-playing')
  })

  /* Cookies: Google Tag Manager only after "Accept all" */
  const KEY = 'cookie-consent'
  const banner = document.getElementById('cookie')
  const read = () => {
    try {
      return localStorage.getItem(KEY)
    } catch {
      return null
    }
  }
  const loadGtm = () => {
    const id = banner && banner.dataset.gtm
    if (!id || window.tbnGtm) return
    window.tbnGtm = true
    window.dataLayer = window.dataLayer || []
    window.dataLayer.push({ 'gtm.start': Date.now(), event: 'gtm.js' })
    const s = document.createElement('script')
    s.async = true
    s.src = 'https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(id)
    document.head.appendChild(s)
  }
  if (banner) {
    const choice = read()
    if (choice === 'all') loadGtm()
    if (!choice) banner.hidden = false
    banner.addEventListener('click', (e) => {
      const btn = e.target.closest('[data-consent]')
      if (!btn) return
      const value = btn.dataset.consent
      try {
        localStorage.setItem(KEY, value)
      } catch {
        /* storage blocked: the banner comes back on the next visit */
      }
      banner.hidden = true
      if (value === 'all') loadGtm()
      // Analytics was running and the visitor withdrew consent: reload so it stops.
      else if (window.tbnGtm) location.reload()
    })
    $$('[data-cookie-settings]').forEach((b) =>
      b.addEventListener('click', () => {
        banner.hidden = false
        banner.querySelector('button')?.focus()
      }),
    )
  }
})()
