define(function () {

  var popInPopOutPeriod = 5000;
  var popInPopOutTimeOut;

  /**
   * Shows an element for x seconds.
   * Works with visiblity!
   * Works together with Dom.popIn and Dom.popOut.
   * Passed element must have visibility hidden.
   *
   * @param elm {Element}
   */
  var popInPopOut = function(elm) {
    window.clearTimeout(popInPopOutTimeOut);
    popIn(elm);
    popInPopOutTimeOut = window.setTimeout(function() {
      popOut(elm);
    }, popInPopOutPeriod);
  };

  /**
   * Hide an element.
   * Works together with Dom.popIn and Dom.popInPopOut.
   * Works with visibility.
   *
   * @param elm {Element}
   */
  var popOut = function(elm) {
    elm.style.visibility = "hidden";
  };

  /**
   * Show an element.
   * Works together with Dom.popIn and Dom.popInPopOut.
   * Works with visibility.
   *
   * @param elm {Element}
   */
  var popIn = function(elm) {
    elm.style.visibility = "visible";
  };

  var show = function(elm) {
    elm.style.display = "block";
  };

  var hide = function(elm) {
    elm.style.display = "none";
  };

  var getSelectedOption = function(select) {
    var index = select.selectedIndex;
    if (index >= 0) {
      return select.options[select.selectedIndex];
    }
    return null;
  };

  return {
    popIn: popIn,
    popOut: popOut,
    popInPopOut: popInPopOut,
    show: show,
    hide: hide,
    getSelectedOption: getSelectedOption
  };

});