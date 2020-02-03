Route66Seo = window.Route66Seo || {};

(function(Route66Seo, $) {
  'use strict';

  Route66Seo.start = function() {

    // Options
    this.options = Joomla.getOptions('Route66SeoOptions');

    // i18n
    var i18n = this.options.i18n || {
      domain: 'js-text-analysis',
      locale_data: {
        'js-text-analysis': {
          '': {}
        }
      }
    };

    // PHP versions older than 7 could not decode an empty string
    if(i18n.locale_data['js-text-analysis']._empty_) {
      i18n.locale_data['js-text-analysis'][''] = i18n.locale_data['js-text-analysis']._empty_;
    }

    var Route66i18n = new Route66Jed(i18n);

    // SEO analyzer
    this.seoAssessor = new Route66SEOAssessor(Route66i18n);
    for (var name in Route66SEOAssessments) {
      if (Route66SEOAssessments[name].identifier) {
        this.seoAssessor.addAssessment(name, Route66SEOAssessments[name]);
      } else {
        var constructor = Route66SEOAssessments[name];
        var assesment = new constructor();
        this.seoAssessor.addAssessment(name, assesment);
      }
    }

    // Results
    this.results = [];
    this.score = 0;
    this.previousScore = 0;

    // Elements
    this.$results = $('#route66-seo-analysis');
    this.$scoreCircle = $('#route66-seo-score');
    this.$scoreText = $('#route66-seo-score-text');
    this.$scoreBadge = $('#route66-seo-score-badge');
    this.$preview = $('#route66-seo-preview');

    this.$keywordField = $(this.options.fields.keyword);
    this.$titleField = $(this.options.fields.title);
    if (this.options.fields.pagetitle) {
      this.$pageTitleField = $(this.options.fields.pagetitle);
    }
    this.$aliasField = $(this.options.fields.alias);
    this.$descriptionField = $(this.options.fields.description);
    this.$scoreField = $(this.options.fields.score);

    if (this.options.option === 'com_k2') {
      this.$deleteImageCheckbox = $('#del_image');
      this.$uploadImageField = $('input[name="image"]');
      this.$existingImageField = $('#existingImageValue');
      this.$imageCaptionField = $('input[name="image_caption"]');
    }

    if (this.options.option === 'com_content') {
      this.$introImage = $('#jform_images_image_intro');
      this.$introImageAlt = $('#jform_images_image_intro_alt');
      this.$fullImage = $('#jform_images_image_fulltext');
      this.$fullImageAlt = $('#jform_images_image_fulltext_alt');
    }

    if (this.options.position === 'toolbar' || this.options.position === 'sidebar') {

      this.$keywordField.val(this.options.keywordValue);

      var scoreFieldClone = this.$scoreField.clone();
      scoreFieldClone.removeAttr('id').attr('type', 'hidden');

      var keywordFieldClone = this.$keywordField.clone();
      keywordFieldClone.removeAttr('id').attr('type', 'hidden');

      $('form[name="adminForm"]').append(scoreFieldClone);
      $('form[name="adminForm"]').append(keywordFieldClone);
      this.clones = {
        $scoreField: scoreFieldClone,
        $keywordField: keywordFieldClone
      };
    }

    // Editor
    if (this.options.editor === 'tinymce') {
      this.editor = tinymce.get(this.options.fields.text.substr(1));
    } else if (this.options.editor === 'jce') {
      this.editor = tinymce.getInstanceById(this.options.fields.text.substr(1));
    } else {
      this.editor = null;
      this.$contentField = $(this.options.fields.text);
    }

    // Measure element
    this.createMeasureElement();

    // Add events
    this.addEvents();

    // Run
    this.analyze();
  };

  Route66Seo.addEvents = function() {
    this.$keywordField.on('change', $.proxy(this.analyze, this));
    this.$titleField.on('change', $.proxy(this.analyze, this));
    if (this.$pageTitleField) {
      this.$pageTitleField.on('change', $.proxy(this.analyze, this));
    }
    this.$aliasField.on('change', $.proxy(this.analyze, this));
    this.$descriptionField.on('change', $.proxy(this.analyze, this));
    if (this.options.editor === 'tinymce') {
      this.editor.on('change', $.proxy(this.analyze, this));
    } else if (this.options.editor === 'jce') {
      this.editor.onChange.add($.proxy(this.analyze, this));
    } else {
      this.$contentField.on('change', $.proxy(this.analyze, this));
    }


    if (this.options.option === 'com_k2') {
      this.$deleteImageCheckbox.on('change', $.proxy(this.analyze, this));
      this.$uploadImageField.on('change', $.proxy(this.analyze, this));
      this.$existingImageField.on('change', $.proxy(this.analyze, this));
      this.$imageCaptionField.on('change', $.proxy(this.analyze, this));
    }

    if (this.options.option === 'com_content') {
      this.$introImage.on('change', $.proxy(this.analyze, this));
      this.$fullImage.on('change', $.proxy(this.analyze, this));
      this.$introImageAlt.on('change', $.proxy(this.analyze, this));
      this.$fullImageAlt.on('change', $.proxy(this.analyze, this));
    }

  };

  Route66Seo.analyze = function() {
    this.paper = new Route66Paper(this.getPaperText(), this.getPaperAttributes());
    this.seoAssessor.assess(this.paper);
    this.previousScore = this.score;
    this.score = Math.max(0, this.seoAssessor.calculateOverallScore());
    this.results = this.seoAssessor.getValidResults();
    this.results.sort(function(a, b) {
      return a.score - b.score;
    });
    this.render();

    if (this.clones) {
      this.clones.$keywordField.val(this.$keywordField.val());
    }
  };

  Route66Seo.render = function() {
    this.renderPreview();
    this.renderScore();
    this.renderAnalysis();
  };

  Route66Seo.renderAnalysis = function() {
    var buffer = '';
    $.each(this.results, $.proxy(function(index, result) {
      result.rating = this.scoreToRating(result.score);
      var icon;
      if (result.rating === 'good') {
        icon = 'icon-ok';
      } else if (result.rating === 'ok') {
        icon = 'icon-warning';
      } else {
        icon = 'icon-not-ok';
      }
      buffer += '<div class="route66-seo-analysis-score route66-seo-analysis-score-' + result.rating + '"><span class="route66-seo-analysis-icon ' + icon + '"></span><span class="route66-seo-analysis-text">' + result.text + '</span></div>';
    }, this));
    this.$results.html(buffer);
  };

  Route66Seo.renderPreview = function() {
    var title = this.paper.getTitle();
    var description = this.paper.getDescription();
    if (!description) {
      description = Route66StripHTML(this.paper.getText());
    }
    description = description.substr(0, 320);
    var buffer = '<h4 class="route66-seo-preview-title">' + title + '</h4><div class="route66-seo-preview-url">' + this.getUrl() + '</div><div class="route66-seo-preview-description">' + description + '</div>';
    this.$preview.html(buffer);
  };

  Route66Seo.renderScore = function() {
    var color;
    var badge;
    if (this.score > 70) {
      color = '#46a546';
      badge = 'success';
    } else if (this.score > 40) {
      color = '#c67605';
      badge = 'warning';
    } else {
      color = '#bd362f';
      badge = 'important';
    }
    var size = this.options.scoreSize || 50;
    this.$scoreCircle.circleProgress({
      size: size,
      value: this.score / 100,
      fill: color,
      animationStartValue: this.previousScore / 100
    }).on('circle-animation-progress', $.proxy(function(event, progress, stepValue) {
      this.$scoreText.text(parseInt(stepValue * 100));
    }, this));
    this.$scoreField.val(this.score);
    this.$scoreBadge.text(this.score).removeAttr('class').addClass('badge badge-' + badge);
    if (this.clones) {
      this.clones.$scoreField.val(this.score);
    }
  };

  Route66Seo.getPaperText = function() {
    var text = '';
    if (this.options.option === 'com_k2') {
      if (this.$deleteImageCheckbox.length || this.$uploadImageField.val() || this.$existingImageField.val()) {
        text += '<img alt="' + (this.$imageCaptionField.val() || this.$titleField.val()) + '" />';
      }
    }
    if (this.options.option === 'com_content') {
      if (this.$introImage.val()) {
        text += '<img alt="' + this.$introImageAlt.val() + '" />';
      }
      if (this.$fullImage.val()) {
        text += '<img alt="' + this.$fullImage.val() + '" />';
      }
    }

    if (this.editor) {
      text += this.editor.getContent();
    } else {
      text += this.$contentField.val();
    }
    var readmore = 'id="system-readmore';
    if (this.options.split && text.indexOf(readmore) !== -1) {
      var parts = text.split(readmore);
      text = parts[1];
    }
    return text;
  };

  Route66Seo.getPaperAttributes = function() {
    var title;
    if (this.$pageTitleField) {
      title = this.options.overrides.title || this.$pageTitleField.val() || this.$titleField.val();
    } else {
      title = this.options.overrides.title || this.$titleField.val();
    }
    if (this.options.sitename_in_title == 1) {
      title = this.options.sitename + ' - ' + title;
    } else if (this.options.sitename_in_title == 2) {
      title += ' - ' + this.options.sitename;
    }
    var attributes = {
      keyword: this.$keywordField.val(),
      description: this.options.overrides.description || this.$descriptionField.val(),
      title: title,
      titleWidth: 0,
      url: this.getSlug()
    };
    attributes.titleWidth = this.measureWidth(attributes.title);
    return attributes;
  };

  Route66Seo.getUrl = function() {
    return this.options.site + this.getSlug();
  };

  Route66Seo.getSlug = function() {
    var url = this.options.url;
    return url.replace(this.options.aliasToken, this.$aliasField.val());
  };

  Route66Seo.scoreToRating = function(score) {
    var rating;
    if (score === -1) {
      rating = 'error';
    } else if (score === 0) {
      rating = 'feedback';
    } else if (score <= 4) {
      rating = 'bad';
    } else if (score > 4 && score <= 7) {
      rating = 'ok';
    } else if (score > 7) {
      rating = 'good';
    }
    return rating;
  };

  Route66Seo.createMeasureElement = function() {
    this.measureElement = document.createElement('div');
    this.measureElement.id = 'route66-yoast-measurement-element';
    this.measureElement.style.position = 'absolute';
    this.measureElement.style.left = '-9999em';
    this.measureElement.style.top = 0;
    this.measureElement.style.height = 0;
    this.measureElement.style.overflow = 'hidden';
    this.measureElement.style.fontFamily = 'Arial';
    this.measureElement.style.fontSize = '18px';
    this.measureElement.style.fontWeight = '400';
    document.body.appendChild(this.measureElement);
  };

  Route66Seo.measureWidth = function(text) {
    this.measureElement.innerHTML = text;
    return this.measureElement.offsetWidth;
  };

}(Route66Seo, jQuery));


jQuery(window).load(function() {
  // Delay for JCE...
  window.setTimeout(function() {
    Route66Seo.start();
  }, 700);
});

jQuery(document).ready(function() {
  var body = jQuery('body');
  jQuery('#route66-seo-dropdown-button').on('click', function(event) {
    event.preventDefault();
    body.toggleClass('route66-seo-dropdown-opened');
  });
  jQuery('#route66-seo-dropdown-overlay').on('click', function(event) {
    event.preventDefault();
    body.removeClass('route66-seo-dropdown-opened');
  });
  jQuery(document).keypress(function(event) {
    if(event.which == 13 && body.hasClass('route66-seo-dropdown-opened')) {
      event.preventDefault();
      body.removeClass('route66-seo-dropdown-opened');
    }
  });
});
