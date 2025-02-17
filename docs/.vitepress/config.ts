import { defineConfig } from 'vitepress'

export default defineConfig({
  title: 'Documentation Appli Photo PHP',
  description: 'Documentation technique pour l\'application de gestion de photos en PHP',
  lang: 'fr-FR',
  base: '/appli-photo-php/', // IMPORTANT : définit le chemin de base pour GitHub Pages
  server: {
    port: 3000
  },
  ignoreDeadLinks: true,
  themeConfig: {
    nav: [
      { text: 'Accueil', link: '/' },
      { text: 'Guide', link: '/guide/getting-started' },
      { text: 'Utilisation', link: '/guide/usage' },
      { text: 'Framework CSS', link: '/features/css-framework' },
      { text: 'GitHub', link: 'https://github.com/TheaCOLINOT/appli-photo-php' }
    ],
    sidebar: {
      '/guide/': [
        {
          text: 'Guide',
          items: [
            { text: 'Démarrage', link: '/guide/getting-started' },
            { text: 'Utilisation', link: '/guide/usage' }
          ]
        }
      ],
      '/features/': [
        {
          text: 'Fonctionnalités',
          items: [
            { text: 'Framework CSS & SASS', link: '/features/css-framework' }
          ]
        }
      ]
    }
  }
})
