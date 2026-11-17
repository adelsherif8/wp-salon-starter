/** One build for the parent and every child theme: Tailwind only keeps classes it finds in these files,
 *  so PHP templates in BOTH themes must be listed, and class names must never be built from pieces
 *  ("bg-" . $color) or they get purged in production. Colours/fonts are CSS variables set per client. */
module.exports = {
  content: ['./salon-master/**/*.php', './salon-child-*/**/*.php', './salon-master/assets/src/**/*.js'],
  theme: {
    extend: {
      colors: {
        ink: 'rgb(var(--salon-ink) / <alpha-value>)',
        paper: 'rgb(var(--salon-paper) / <alpha-value>)',
        accent: 'var(--salon-accent)',
        accent2: 'var(--salon-accent2)',
        muted: 'var(--salon-muted)',
      },
      fontFamily: { display: 'var(--salon-display)', body: 'var(--salon-body)' },
    },
  },
  plugins: [require('@tailwindcss/typography')],
};
