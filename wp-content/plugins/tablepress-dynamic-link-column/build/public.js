/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./assets/public/index.js ***!
  \********************************/
/**
 * TablePress "Add to Gravity form list" public scripts
 *
 * @since 0.1.0
 */
if ('loading' === document.readyState) {
  document.addEventListener('DOMContentLoaded', initTablePressAddToGformPublic);
} else {
  initTablePressAddToGformPublic();
}
/**
 * Handle checkbox submit
 *
 * @since 0.1.0
 */


function initTablePressAddToGformPublic() {
  const $ = jQuery,
        $submit = $('.tp-add-to-gform-list-submit');

  if ($submit.length < 1) {
    return;
  }

  $submit.on('click', doCheckboxesSubmit);

  function doCheckboxesSubmit() {
    const $this = $(this),
          $table = $($this.data('tp-add-to-gform-list-for'));

    if ($table.length < 1) {
      return;
    }

    $checkedRows = $('[data-tp-add-to-gform-list-for]:checked', $table);

    if ($checkedRows.length < 1) {
      return;
    } // console.log( 'SELECTED', $checkedRows );


    $checkedRows.each((whatever, jimbob, roight) => {
      console.log('BOX', this, whatever, jimbob, roight);
    });
    const url = $this.data('tp-add-to-gform-list-url'),
          fieldName = $this.data('tp-add-to-gform-list-field-name');
  }
}
/******/ })()
;
//# sourceMappingURL=public.js.map