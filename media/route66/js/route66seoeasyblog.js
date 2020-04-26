Route66SeoAnalyzer = window.Route66SeoAnalyzer || {};

(function(Route66SeoAnalyzer, $) {
  'use strict';

  Route66SeoAnalyzer.start = function() {

    // Build html
    var html = '<div class="eb-composer-fieldset"><div id="route66-seo-preview" style="margin-bottom:8px;"></div><input type="text" name="jform[route66seo][keyword]" id="jform_route66seo_keyword" value="" placeholder="Focus Keyword" class="o-form-control"/><div id="route66-seo-score" style="margin: 6px auto 3px auto;"></div><div id="route66-seo-analysis"></div></div>';


    $('[data-id="seo"] > div > div').prepend(html);

    this.options = Joomla.getOptions('Route66SeoAnalyzerOptions');

    // Analyzer
    this.analyzer = new Route66Seo(this.options);

    this.$keywordField = $(this.options.fields.keyword);
    this.$titleField = $(this.options.fields.title);
    if (this.options.fields.pagetitle) {
      this.$pageTitleField = $(this.options.fields.pagetitle);
    }
    this.$aliasField = $(this.options.fields.alias);
    this.$descriptionField = $(this.options.fields.description);
    this.$scoreField = $(this.options.fields.score);

    // Add events
    this.addEvents();

    // Run
    this.analyze();
  };

  Route66SeoAnalyzer.addEvents = function() {
    this.$keywordField.on('change', $.proxy(this.analyze, this));
    this.$titleField.on('change', $.proxy(this.analyze, this));
    if (this.$pageTitleField) {
      this.$pageTitleField.on('change', $.proxy(this.analyze, this));
    }
    this.$aliasField.on('change', $.proxy(this.analyze, this));
    this.$descriptionField.on('change', $.proxy(this.analyze, this));

    EasyBlog.Composer.document.on('input', function() {
      $.proxy(this.analyze, this);
    });

  };

  Route66SeoAnalyzer.analyze = function() {
    this.analyzer.analyze(this.getPaperText(), this.getPaperAttributes());
  };


  Route66SeoAnalyzer.getPaperText = function() {
    var text = EasyBlog.Composer.document.getContent();
    var html = $('<div></div>');
    html.append(text);
    html.find('.ebd-block-toolbar').remove();
    html.find('.ebd-block-viewport').remove();
    html.find('.ebd-block-hint').remove();
    html.find('.ebd-block-action').remove();

    return html.html();
  };

  Route66SeoAnalyzer.getPaperAttributes = function() {
    var title;
    if (this.$pageTitleField) {
      title = this.$pageTitleField.val() || this.$titleField.val();
    } else {
      title = this.$titleField.val();
    }
    if (this.options.sitename_in_title == 1) {
      title = this.options.sitename + ' - ' + title;
    } else if (this.options.sitename_in_title == 2) {
      title += ' - ' + this.options.sitename;
    }
    var attributes = {
      keyword: this.$keywordField.val(),
      description: this.$descriptionField.val(),
      title: title,
      url: this.getSlug(),
      permalink: this.getUrl()
    };

    return attributes;
  };

  Route66SeoAnalyzer.getUrl = function() {
    return this.options.site + this.getSlug();
  };

  Route66SeoAnalyzer.getSlug = function() {
    return this.$aliasField.val();
  };

}(Route66SeoAnalyzer, jQuery));


window.setTimeout(function() {
  Route66SeoAnalyzer.start();
}, 4000);
