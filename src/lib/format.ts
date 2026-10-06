const fmt = new Intl.DateTimeFormat('en-GB', { day: 'numeric', month: 'long', year: 'numeric' })
const fmtShort = new Intl.DateTimeFormat('en-GB', { day: '2-digit', month: 'short' })

export const formatDate = (iso: string) => fmt.format(new Date(iso + 'T12:00:00'))

export const dateParts = (iso: string) => {
  const [day, month] = fmtShort.format(new Date(iso + 'T12:00:00')).split(' ')
  return { day, month, year: iso.slice(0, 4) }
}

export const img = (file: string) => `${import.meta.env.BASE_URL}img/${file}`

// "Today" for placeholder content: upcoming vs past events are split by the real date.
export const isPast = (iso: string) => new Date(iso + 'T23:59:59') < new Date()
