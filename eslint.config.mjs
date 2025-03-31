import htmlPlugin from 'eslint-plugin-html';
import globals from 'globals';
import js from '@eslint/js';

const inlinePHP = {
	meta: {
		name: "process-inline-php-plugin",
		version: "1.2.3",
	},
	processors: {
		"strip-inline-php": {
			meta: {
				name: "inline-php-plugin-processor",
				version: "1.2.3",
			},
			preprocess: (text, filename) => [
			  text.replace(/<\?(?:php)?(.*?)\?>/g, (match, phpContent) => {
				// If the PHP tag is inside an object or array (we check for the presence of a key)
				if (/[\w\-]+\s*:/.test(match)) {
				  // Inside an object or array, replace the PHP code with key assigned `undefined`
				  return '__eslint_value: undefined';
				} else {
				  // If the PHP code is standalone, such as in `value = <?=phpstuff?>;`, replace with `undefined`
				  return 'undefined'; // Or 'null', or another suitable placeholder
				}
			  })
			],
			postprocess(messages, filename) {
				// `messages` argument contains two-dimensional array of Message objects
				// where each top-level array item contains array of lint messages related
				// to the text that was returned in array from preprocess() method

				// you need to return a one-dimensional array of the messages you want to keep
				return [].concat(...messages);
			},
		}
	},
};

export default [
  {
    files: ["app/Views/**/*.php"],
    plugins: {
      html: htmlPlugin, inlinePHP,
    },
	processor: "inlinePHP/strip-inline-php",
    languageOptions: {
      globals: globals.browser,
    },
  },
  

];