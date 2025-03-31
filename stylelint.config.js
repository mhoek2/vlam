module.exports = {
  extends: 'stylelint-config-standard', 

  rules: {
    "color-no-invalid-hex": true,
	"no-empty-source": null,
	"rule-empty-line-before": null
  },
  overrides: [
    {
      files: ["app/Views/**/*.php", "public/assets/css/**/*.css"],
      customSyntax: "postcss-html",
    },
  ],
};