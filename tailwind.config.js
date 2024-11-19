/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./resources/views/**/*.blade.php'],
  theme: {
    extend: {
      colors: {
        'blue1': '#185064',
        'blue2': '#80BCB3',
        'blue3': '#f3f8f6',
      },
      animation: {
        slide: 'slide 20s linear infinite', // Animation fluide sur 20 secondes
      },
      keyframes: {
        slide: {
          '0%': { transform: 'translateX(0px)' },
          '10%': { transform: 'translateX(0px)' }, // Pause pour le premier groupe
          '15%': { transform: 'translateX(-332px)' }, // Décalage vers la deuxième image
          '25%': { transform: 'translateX(-332px)' }, // Pause pour le deuxième groupe
          '30%': { transform: 'translateX(-664px)' }, // Décalage vers la troisième image
          '40%': { transform: 'translateX(-664px)' }, // Pause pour le troisième groupe
          '45%': { transform: 'translateX(-996px)' }, // Décalage vers la quatrième image
          '55%': { transform: 'translateX(-996px)' }, // Pause pour le quatrième groupe
          '60%': { transform: 'translateX(-1328px)' }, // Décalage vers la cinquième image
          '70%': { transform: 'translateX(-1328px)' }, // Pause pour le cinquième groupe
          '75%': { transform: 'translateX(-1660px)' }, // Décalage vers la sixième image
          '85%': { transform: 'translateX(-1660px)' }, // Pause pour la sixième image
          '90%': { transform: 'translateX(-1992px)' }, // Décalage vers les images dupliquées
          '100%': { transform: 'translateX(-1992px)' }, // Retour fluide à la boucle
        },
      },
    },
  },
  plugins: [],
};
