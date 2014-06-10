<pre><code>
var direction;

// Wird aufgerufen, sobald das
// Hauptprogramm die Erfolgsmeldung
// an den Web Worker sendet.
onmessage = function (event) {

  // Die Erfolgsmeldung wird mit dem
  // Feld 'done' (true | false) gesendet.
  var done = event.data.done;

  // Neue Richtung bestimmen.
  if (done) {
    direction =
      holdOrChangeDirection(direction);
  } else {
    direction = getRandomDirection();
  }

  // Teilt dem Hauptprogramm die neue
  // Richtung mit. Die Richtung wird
  // mit dem Feld 'direction' gesendet.
  // Die zu wiederholende Id wird mit
  // dem Feld 'id' gesendet.
  postMessage({
    id: event.data.id,
    direction: direction
  });
};

function holdOrChangeDirection(dir) {
  if (Math.random() &lt; 0.05) {
    return getRandomDirection();
  } else {
    return dir;
  }
}

function getRandomDirection() {
  var randomDirection;
  var randomNumber = Math.random();
  if (randomNumber &lt; 0.25) {
    randomDirection = "up";
  } else if (randomNumber &lt; 0.5) {
    randomDirection = "down";
  } else if (randomNumber &lt; 0.75) {
    randomDirection = "left";
  } else {
    randomDirection = "right";
  }
  return randomDirection;
}

</code></pre>