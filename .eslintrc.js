// https://eslint.org/docs/user-guide/configuring

module.exports = {
  env: {
    browser: true,
    es6: true
  },
  extends: [
    'standard'
  ],
  globals: {
    Atomics: 'readonly',
    SharedArrayBuffer: 'readonly',
    $: false
  },
  parserOptions: {
    sourceType: 'module'
  },
  rules: {
    'no-new': 'off'
  }
}
