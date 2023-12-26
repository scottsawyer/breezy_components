(function(Drupal, once) {
  'use strict'

  /**
   * Click handler behavior buttons.
   *
   * @type {Object}
   */
  Drupal.behaviors.paragraphBehaviorsToggle = {
    attach(context) {
      once('add-click-handler', '.js-paragraphs-button-behaviors', context).forEach(element => {
        const $button = element;
        const $paraWidget = element.closest('.paragraph-top').parent();

        $button.classList.add('content-active');
        $paraWidget.classList.add('content-active');

        $button.addEventListener('click', event => {
          const $trigger = event.target;

          const $currentParaWidget = $trigger.closest('.paragraph-top').parent();

          if ($currentParaWidget.classList.contains('content-active')) {
            $trigger.classList.remove('content-active');
            $trigger.classList.add('behavior-active');
            $trigger.innerHTML(Drupal.t("Content"));

            $currentParaWidget.querySelector('.paragraphs-behavior').classList.remove('breezy-hide');
            $currentParaWidget.querySelector('.paragraphs-subform').classList.add('breezy-hide');
          }
          else {
            $trigger.classList.remove('behavior-active');
            $trigger.classList.add('content-active');
            $trigger.innerHTML(Drupal.t("Behaviors"));
            $currentParaWidget.querySelector('.paragraphs-behavior').classList.add('breezy-hide');
            $currentParaWidget.querySelector('.paragraphs-subform').classList.remove('breezy-hide');
            $currentParaWidget.classList.remove('behavior-active');
            $currentParaWidget.classList.add('content-active');

          }

          event.preventDefault();
          return false;
        });
      });
    }
  };

})(Drupal, once);
