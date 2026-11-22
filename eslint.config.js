import neostandard from 'neostandard'

export default [
  ...neostandard({
    env: ['browser'],
    globals: ['$'],
  }),
  {
    rules: {
      'no-new': 'off',
    },
  },
]
